<?php

namespace Hp;

//  PROJECT HONEY POT ADDRESS DISTRIBUTION SCRIPT
//  For more information visit: http://www.projecthoneypot.org/
//  Copyright (C) 2004-2020, Unspam Technologies, Inc.
//
//  This program is free software; you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation; either version 2 of the License, or
//  (at your option) any later version.
//
//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU General Public License for more details.
//
//  You should have received a copy of the GNU General Public License
//  along with this program; if not, write to the Free Software
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
//  02111-1307  USA
//
//  If you choose to modify or redistribute the software, you must
//  completely disconnect it from the Project Honey Pot Service, as
//  specified under the Terms of Service Use. These terms are available
//  here:
//
//  http://www.projecthoneypot.org/terms_of_service_use.php
//
//  The required modification to disconnect the software from the
//  Project Honey Pot Service is explained in the comments below. To find the
//  instructions, search for:  *** DISCONNECT INSTRUCTIONS ***
//
//  Generated On: Sun, 27 Sep 2020 06:11:04 -0400
//  For Domain: www.the-wayshowers.org
//
//

//  *** DISCONNECT INSTRUCTIONS ***
//
//  You are free to modify or redistribute this software. However, if
//  you do so you must disconnect it from the Project Honey Pot Service.
//  To do this, you must delete the lines of code below located between the
//  *** START CUT HERE *** and *** FINISH CUT HERE *** comments. Under the
//  Terms of Service Use that you agreed to before downloading this software,
//  you may not recreate the deleted lines or modify this software to access
//  or otherwise connect to any Project Honey Pot server.
//
//  *** START CUT HERE ***

define('__REQUEST_HOST', 'hpr5.projecthoneypot.org');
define('__REQUEST_PORT', '80');
define('__REQUEST_SCRIPT', '/cgi/serve.php');

//  *** FINISH CUT HERE ***

interface Response
{
    public function getBody();
    public function getLines(): array;
}

class TextResponse implements Response
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getBody()
    {
        return $this->content;
    }

    public function getLines(): array
    {
        return explode("\n", $this->content);
    }
}

interface HttpClient
{
    public function request(string $method, string $url, array $headers = [], array $data = []): Response;
}

class ScriptClient implements HttpClient
{
    private $proxy;
    private $credentials;

    public function __construct(string $settings)
    {
        $this->readSettings($settings);
    }

    private function getAuthorityComponent(string $authority = null, string $tag = null)
    {
        if(is_null($authority)){
            return null;
        }
        if(!is_null($tag)){
            $authority .= ":$tag";
        }
        return $authority;
    }

    private function readSettings(string $file)
    {
        if(!is_file($file) || !is_readable($file)){
            return;
        }

        $stmts = file($file);

        $settings = array_reduce($stmts, function($c, $stmt){
            list($key, $val) = \array_pad(array_map('trim', explode(':', $stmt)), 2, null);
            $c[$key] = $val;
            return $c;
        }, []);

        $this->proxy       = $this->getAuthorityComponent($settings['proxy_host'], $settings['proxy_port']);
        $this->credentials = $this->getAuthorityComponent($settings['proxy_user'], $settings['proxy_pass']);
    }

    public function request(string $method, string $uri, array $headers = [], array $data = []): Response
    {
        $options = [
            'http' => [
                'method' => strtoupper($method),
                'header' => $headers + [$this->credentials ? 'Proxy-Authorization: Basic ' . base64_encode($this->credentials) : null],
                'proxy' => $this->proxy,
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $body = file_get_contents($uri, false, $context);

        if($body === false){
            trigger_error(
                "Unable to contact the Server. Are outbound connections disabled? " .
                "(If a proxy is required for outbound traffic, you may configure " .
                "the honey pot to use a proxy. For instructions, visit " .
                "http://www.projecthoneypot.org/settings_help.php)",
                E_USER_ERROR
            );
        }

        return new TextResponse($body);
    }
}

trait AliasingTrait
{
    private $aliases = [];

    public function searchAliases($search, array $aliases, array $collector = [], $parent = null): array
    {
        foreach($aliases as $alias => $value){
            if(is_array($value)){
                return $this->searchAliases($search, $value, $collector, $alias);
            }
            if($search === $value){
                $collector[] = $parent ?? $alias;
            }
        }

        return $collector;
    }

    public function getAliases($search): array
    {
        $aliases = $this->searchAliases($search, $this->aliases);
    
        return !empty($aliases) ? $aliases : [$search];
    }

    public function aliasMatch($alias, $key)
    {
        return $key === $alias;
    }

    public function setAlias($key, $alias)
    {
        $this->aliases[$alias] = $key;
    }

    public function setAliases(array $array)
    {
        array_walk($array, function($v, $k){
            $this->aliases[$k] = $v;
        });
    }
}

abstract class Data
{
    protected $key;
    protected $value;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function key()
    {
        return $this->key;
    }

    public function value()
    {
        return $this->value;
    }
}

class DataCollection
{
    use AliasingTrait;

    private $data;

    public function __construct(Data ...$data)
    {
        $this->data = $data;
    }

    public function set(Data ...$data)
    {
        array_map(function(Data $data){
            $index = $this->getIndexByKey($data->key());
            if(is_null($index)){
                $this->data[] = $data;
            } else {
                $this->data[$index] = $data;
            }
        }, $data);
    }

    public function getByKey($key)
    {
        $key = $this->getIndexByKey($key);
        return !is_null($key) ? $this->data[$key] : null;
    }

    public function getValueByKey($key)
    {
        $data = $this->getByKey($key);
        return !is_null($data) ? $data->value() : null;
    }

    private function getIndexByKey($key)
    {
        $result = [];
        array_walk($this->data, function(Data $data, $index) use ($key, &$result){
            if($data->key() == $key){
                $result[] = $index;
            }
        });

        return !empty($result) ? reset($result) : null;
    }
}

interface Transcriber
{
    public function transcribe(array $data): DataCollection;
    public function canTranscribe($value): bool;
}

class StringData extends Data
{
    public function __construct($key, string $value)
    {
        parent::__construct($key, $value);
    }
}

class CompressedData extends Data
{
    public function __construct($key, string $value)
    {
        parent::__construct($key, $value);
    }

    public function value()
    {
        $url_decoded = base64_decode(str_replace(['-','_'],['+','/'],$this->value));
        if(substr(bin2hex($url_decoded), 0, 6) === '1f8b08'){
            return gzdecode($url_decoded);
        } else {
            return $this->value;
        }
    }
}

class FlagData extends Data
{
    private $data;

    public function setData($data)
    {
        $this->data = $data;
    }

    public function value()
    {
        return $this->value ? ($this->data ?? null) : null;
    }
}

class CallbackData extends Data
{
    private $arguments = [];

    public function __construct($key, callable $value)
    {
        parent::__construct($key, $value);
    }

    public function setArgument($pos, $param)
    {
        $this->arguments[$pos] = $param;
    }

    public function value()
    {
        ksort($this->arguments);
        return \call_user_func_array($this->value, $this->arguments);
    }
}

class DataFactory
{
    private $data;
    private $callbacks;

    private function setData(array $data, string $class, DataCollection $dc = null)
    {
        $dc = $dc ?? new DataCollection;
        array_walk($data, function($value, $key) use($dc, $class){
            $dc->set(new $class($key, $value));
        });
        return $dc;
    }

    public function setStaticData(array $data)
    {
        $this->data = $this->setData($data, StringData::class, $this->data);
    }

    public function setCompressedData(array $data)
    {
        $this->data = $this->setData($data, CompressedData::class, $this->data);
    }

    public function setCallbackData(array $data)
    {
        $this->callbacks = $this->setData($data, CallbackData::class, $this->callbacks);
    }

    public function fromSourceKey($sourceKey, $key, $value)
    {
        $keys = $this->data->getAliases($key);
        $key = reset($keys);
        $data = $this->data->getValueByKey($key);

        switch($sourceKey){
            case 'directives':
                $flag = new FlagData($key, $value);
                if(!is_null($data)){
                    $flag->setData($data);
                }
                return $flag;
            case 'email':
            case 'emailmethod':
                $callback = $this->callbacks->getByKey($key);
                if(!is_null($callback)){
                    $pos = array_search($sourceKey, ['email', 'emailmethod']);
                    $callback->setArgument($pos, $value);
                    $this->callbacks->set($callback);
                    return $callback;
                }
            default:
                return new StringData($key, $value);
        }
    }
}

class DataTranscriber implements Transcriber
{
    private $template;
    private $data;
    private $factory;

    private $transcribingMode = false;

    public function __construct(DataCollection $data, DataFactory $factory)
    {
        $this->data = $data;
        $this->factory = $factory;
    }

    public function canTranscribe($value): bool
    {
        if($value == '<BEGIN>'){
            $this->transcribingMode = true;
            return false;
        }

        if($value == '<END>'){
            $this->transcribingMode = false;
        }

        return $this->transcribingMode;
    }

    public function transcribe(array $body): DataCollection
    {
        $data = $this->collectData($this->data, $body);

        return $data;
    }

    public function collectData(DataCollection $collector, array $array, $parents = []): DataCollection
    {
        foreach($array as $key => $value){
            if($this->canTranscribe($value)){
                $value = $this->parse($key, $value, $parents);
                $parents[] = $key;
                if(is_array($value)){
                    $this->collectData($collector, $value, $parents);
                } else {
                    $data = $this->factory->fromSourceKey($parents[1], $key, $value);
                    if(!is_null($data->value())){
                        $collector->set($data);
                    }
                }
                array_pop($parents);
            }
        }
        return $collector;
    }

    public function parse($key, $value, $parents = [])
    {
        if(is_string($value)){
            if(key($parents) !== NULL){
                $keys = $this->data->getAliases($key);
                if(count($keys) > 1 || $keys[0] !== $key){
                    return \array_fill_keys($keys, $value);
                }
            }

            end($parents);
            if(key($parents) === NULL && false !== strpos($value, '=')){
                list($key, $value) = explode('=', $value, 2);
                return [$key => urldecode($value)];
            }

            if($key === 'directives'){
                return explode(',', $value);
            }

        }

        return $value;
    }
}

interface Template
{
    public function render(DataCollection $data): string;
}

class ArrayTemplate implements Template
{
    public $template;

    public function __construct(array $template = [])
    {
        $this->template = $template;
    }

    public function render(DataCollection $data): string
    {
        $output = array_reduce($this->template, function($output, $key) use($data){
            $output[] = $data->getValueByKey($key) ?? null;
            return $output;
        }, []);
        ksort($output);
        return implode("\n", array_filter($output));
    }
}

class Script
{
    private $client;
    private $transcriber;
    private $template;
    private $templateData;
    private $factory;

    public function __construct(HttpClient $client, Transcriber $transcriber, Template $template, DataCollection $templateData, DataFactory $factory)
    {
        $this->client = $client;
        $this->transcriber = $transcriber;
        $this->template = $template;
        $this->templateData = $templateData;
        $this->factory = $factory;
    }

    public static function run(string $host, int $port, string $script, string $settings = '')
    {
        $client = new ScriptClient($settings);

        $templateData = new DataCollection;
        $templateData->setAliases([
            'doctype'   => 0,
            'head1'     => 1,
            'robots'    => 8,
            'nocollect' => 9,
            'head2'     => 1,
            'top'       => 2,
            'legal'     => 3,
            'style'     => 5,
            'vanity'    => 6,
            'bottom'    => 7,
            'emailCallback' => ['email','emailmethod'],
        ]);

        $factory = new DataFactory;
        $factory->setStaticData([
            'doctype' => '<!DOCTYPE html>',
            'head1'   => '<html><head>',
            'head2'   => '<title>www.the-wayshowers.org</title></head>',
            'top'     => '<body><div align="center">',
            'bottom'  => '</div></body></html>',
        ]);
        $factory->setCompressedData([
            'robots'    => 'H4sIAAAAAAAAA7PJTS1JVMhLzE21VSrKT8ovKVZSSM7PK0nNK7FVystPLErOyCxL1UnLz8nJL9fJy8_MS0mtULIDAIxwGpI3AAAA',
            'nocollect' => 'H4sIAAAAAAAAA7PJTS1JVMhLzE21VcrL103NTczM0U3Oz8lJTS7JzM9TUkjOzytJzSuxVdJXsgMAKsBXli0AAAA',
            'legal'     => 'H4sIAAAAAAAAA61a23LbRhJ936-YlbcUu0qW5btdUFTFyLTFVEx5SdopPw6AITEWiOHOAKK5X7-nu2dAXRjaqdo8WBIw1-7Tp083ctrqvDaqMHUdVrqwzeLXg5MD_nulyzL9nTtfGk-_nv3jtPX0T3l22rZnh00eVpmSH_GP0_zsdO6aVhWudv7XB-_5v7P56RN6enb6JL89Tf2NRfT9Rf5ipEkjd7yze965n95hcW_kdvxsePjgzbPs43T7Ek8PH7x6mY3f3Xp2fjmmv09z3z_zZ7PKqLXJw-k_Hz9WoTVr7UvlVqaZ68KUakN_Pn58Zluj5t4dPnh68jZTa_r5IqN_X2ZFpTau23dsXRQmYPDTlxmWpF9eZZUNtH3r6O9nTzPXqdDl30zRKnmGMbILNuZ932Q1PX6arYEV7MQnLty18ao0uWu09Wpuc2_ovE1pW-toB9dWhua9yFRr_FKOoRY0r6GF-HCBNm3Tfn-aXIaxqR68eZ2lB2SGv7hsQoE-fPD2bVaYFS5S0YpPs2DihbB_ULopMbWhVyeZpS280WU_WEy8D5EFdnideTPvarHL5lgNms0-iI1d8_iiW-pGfbFB3NbSznphmjYoN981uY2TYUBlYdBrmVh2un4YHu1D-7py8YriRRjf1eLvaOPlsZrFCycPeLuIINS-VaUNrW2AhqWtGYEVv8TjhQcycXel4UJcQHUrTLE-0ChcBu-bVpYuya3wl-po74ZO9AI3x4Awx1zY8U0mJkQQ2LZynRxZtbzZ3HW-rYpa43TB1POgWxvmFhguzbWp3YrwY-uaNt5GBG5kvq-8EcSEfZZdi20YBH_K3Dy5xxzT05vBupMayp_jur9ivumn4flo8MctnvhjdD4cT8EggOHN55PhdDYZnc9G91lkujKF1bXyJrTxTgXirwG0GqXVtWV75kbDS3Brs1GrbrUyLVnKhU5iNt3c-V-Cqm1hJPxes48Q94Aw_fI6izi2GBmO1Ti6FfjmwKAxJ5n6IqvxqBj0bOewijA2Phwh3bTY9gXIAQg3fMpra9YrZ2HpDXKTW6tgF1UrTre1DRWd9TvP9i6Xo6VFOPa9XteRcmjDlZcxwCWivzRYrrkBT0E_1gIJHMG5yxUfU3etWwJvvKKu600Ph-FSyw1qxfctS1g9GDZ1C1rFedsUWXIKZF0nVgniiGC8NRwvJRt51CrM86aIJ23sfw0xko5xoBGEm9BukL_zztcbddXoa7JE1-gSv2DwyuQ5XmDJXSgNWyoBGZolL1sbveiMBI_4jS-l-ULiezyuXWOOcdM3bylH6OKqEeZvDRzWFJsYfE_fpkguF0YMA57VC28MUyv-Bto0LVvpQJiU1Tuz67xVPG_j2n3XqTlzyOqN-jxV_3p5AiCAQL6KJTs1Z-oJACGo6ojI_4nzKpJ_aL3cOhdgC_sgbhRnvGc704C5ZUstS9Em1xq3AZcreiMWdgtbkIH6cTAtv_lm1qamKCNog-Q0p89SszkJTWTy189jMMHWhEQOQkR54dKd5PRgQcleCDcV8yVAaH4JSoAogWnFtzEnEmIF6eSjpTzFZbVsWcapxKRROwBeK-GRuqOBRWGBgBYHKh1sCs1i-aDabwCxFdxsQ0IHElBlme9TcJR9QP1fmHW_gLsv9X5ede788dPKFwMHn-CTkwy0Pvjtj2HMbH5JjgQGbBcoVyOXtpYEetO1nrQTHpvvGgmYQvpWehj8-SONejs5DDUk4gpJfYN4jIxkAtML4mED3WdbRAYnDNXHPXnpeab5uMguBZK6cvUG9FgoZjxKvrkDI-MnKdTIcO1Wx5H08yB2ul9jaP2YG4QvbByonN91oVW6EE708OD3LsYs57lBEZkR0EUcNEaVHa43t43pzwI0H4AMQMOhAoGrnGd4qBakxXnXlKweGoQfxVTAHVuNkFKkTIP5bkoJXChVAaxv8CjfsIqqRFHikgsbIqA9Xg9KkY-2IW7RErTgRN56zZtB3Ov_RNplF51Hqwj5iHzdyXrJww9ZOoauqPbRU63XoFlkdr1aCTMLQ1BicbsmFklAMx-YyDwBqqFdM0-Az1fxqoRfkyhC1N5LGAAMkVxbwe3iI0rspPxtwwVo2_krswkESGuIPEhbykL7rjMosQCjEwQ7jxQSs3yP1zdZn3lCNGdrRBRASsqTnYIw3X3NJ14iPbdSdVU2ljlL6CQ4r3LuSpBByZ7WfiVlCgWSvgHxPKqODgSPsNO2ERJtVWWXKvL2vqNIzLC4M_4aauxYfUUCxuNgorKPVc1ObyawmJiVCxnrXYP4DbSiADkpldxFqKrb_r-jgn_Af-EH9Pl3WfrnGJ8L8OH55eTdVBSks1Q7r5yr1co7CCQwG6Up4A1JsEVyMl68uO8Yl-_vlPRvXmWj6Wh2n2HFMdswRpQlF0FhVvq6z9MohrwaMelAfX_yjmN5ibyPMDVRL6rglmYN7jS9pqQXzzKqth7G-t2oA8Zd3gVAY5Y4dyQ0SXkYlZInXdlJ0nZti_C77uqF9vhriWBEdF9bb2vax6xFfDQW7IRAhvgtKlanSeoTMgQuyFJOjrEvh-6mmZQicWy6WiwN-hDeSqTcIaSoTKSyBqwh9FHo3JLpvIFncwpvFkxqnnD6hVx0OZmqwYfJcLgPpLOLwUxdDCZfUFeNxh-kgvgwmF1w6TUZjWP74SQbTGZf1SXDTAnEguM8ZL5T_wzGpsqL1RAEOgrmmBN5ofE7LC5EMf6qPg6n08GH4cPpIzW7VDNJr_AA3QRBGNOSJ5xigYuhGsVTPM8-_zYd_vvzcDyjxV5lk-Hg_EJdvifF9yK7GPIY3lHNhpOPU7zaZ__pcPKFbfakpYhry22rD2B_N5qNLsfTfe69Ex6f71esN4kjsgpWe3gA4hRWtb6A9kCKsY6lMkmiGjyLUs02EqAyu-8IpeL84JHqo4IivDQltxhk1PE-Rpyxbm-5FxQ7OaRRdBkFBssgKgwlnjnh29g_2rlwwtNvG0VU05IDH2LFG9XwzuZQSm0opxvjH_UdqL5P8zIW3lFZYcEXYGSK_Fk8Pb2dq5ggDh5J7cOQBaICRy8FLjXX9uTYlHLutEDinSGfpFSDhNpZrNltxqIYiBzB_oCs7NrKCa3tzLyp0iPh1XcK15EWdm437812FUuZfYcimknFHAEE54uJG0HDVnS9AUkuSbTRxVHLRID1MoOlXaBssg9gu7t5qZzp1bF4TxTHSrcV6vGFmy-7FnpWldaTYL6WZiqpRi4rtyUTl02XPLlrwpUFC3G8jJkGbkXme1SS4LNbz8aX48d4_Cz7_HHALZ5bb79w7ck8em852TwGmpEOSrwDslMBqznLJ5G2LkzdwypFEXKdGJb6p8-eUpLkNWUZb4sr5B9ILlNyRirqrpQljqKIb72BxMu1J10lMp71O0VuLDhf79bQCW4kjJvYO0IVvkxHS-1xd7Rr9lWSiSZnCS4po9I-lghRdHJvCoAmTRj3iE73rCSlEDElyJ6qqv7EcfZh37qqE0p8VNLX9tptWXGhucASfQtNESUbqiKZtRTzSzPgJnRI_KS22IplOEp2qk6AoqLtJNxJOkX8o3Q8ToEBp3NdIUoZCQuaCnj1Oldr50qkLn-juFnF4p8YWviVal9VUS98n4VFjLLwSOSB_VHHmiVS4z4WvtniuHl_Us6t9EEieNONXmRsRi0VrzSsUBr3OotcJoxY68jLrjmi2VwHx83o80loNfU_asC3tMso-myouNpmD7CBLXdMI3Jin7pNJYFgIyQlUJoVVbalWbrCa2m3LY7Uok8u6TPNYfp6Qc3fXoqekCSgrVJb5wmKbYIudRvdQh5yt1GackjEmsMo5ZbDm1-LblDPrg9cv3-ejKbvRufMraPLe7wik6lV5F1hTBmPudhHl3nPvamYyqljASRESQxssg72ljoS-3h57p1ExCyGGJG_pIaUAbZ6hcbVbOR15F4VHaUTiyUTJbiR_itiPeVYj1KqZkOVCQxqmupSGQgdM48h_nMpOoJZsz8MUtS25aCiAkx1b_oEwro06mxDpUcPFWpc7hEm8czCztMWa_Y1aKpyUpg4ttC37gb-cGv5CMGRQtU7LSF70zrCeVzQbrFL9EVqRSoA-61b0E3qroHDG2MXFSSyj-o6ugQ1a9P92HKWz7Et0NeR8iuU6kYX6VNhdHZKb7MoEZh9et8KgOmb2daUz7NYvZXyVbNniv3yhATJ3aw-uSOsh7fbiYi6Pcw5-O3OhBh1GC2tfbmaEICHbqaPl0KrvQbuCZQ_TpSpmARY5VJztYYs7DjnosyWrm_Nft4XgPIxcFv_7lN3XBrHpGdCaxfcmwsdKvel9leG0-a9Sx1Hgknanb7qhOjxvpPx4UhNoWxQlR1R3YyibjCevh9OJlKngbsu1UDNLkaTdzT8HSqu0fuRFIVUer3OLunzHHEc__t5NtxZKKWrDMZS_Z3z3OEnKfrMclW7DfIO7jEYnw8V-VU-uD3PzmObWFODrKioogzIfXpRc249vlu4PeH_U-MJ_y8e-AVv_wcCgXCt7yEAAA',
            'style'     => 'H4sIAAAAAAAAAyXMywmAMAwA0FUEr36vbfHYPVKNUAiJJAEVcXcPvgFeMr8JFxhcoSjYCfSsQqKhzTnHXdhDEdqaeTquBrQCdQZsvaHWPTpe3m-4ioJX4cDCGN80_usHtA0rwF0AAAA',
            'vanity'    => 'H4sIAAAAAAAAA22S3U7DMAyFX8XKbtk6Bkxa1lWIaQghwSZ-LrhMm6wNC3HkmJW9PWkZNzBFlmwl_s5xkpxV6QxUxrkYVGV9vRBj0ZVBaX0sSyRtqMsiH5xZiFJVu5rw02s5mM1m89ZqbuTkYhy-5qLImVJo2Ctna78QjOG38QiVcB6-YJLiKsVl6vqRGJKtG5YRndX9kcFyueyIyZuHI2OLnmWJTkOnB4qscmdR-TiMhux2XqFDkoPpdDpPyrLzFDBatuglGafY7k1iXudZRy3yjPU_u3DMndmygD_mL5LqOK3Ln2kVNGS2C9EwB5llbduOAuG7qbhBbw4BeYRUZwIqp2JMfFIlqdgqJ4qH1cPN6gnWt7B5Wt-vli9wt35cvcFm_ZJnqshLOsn_9Mn6x6jCD3EC-pz24E7R3kQ2BBtCTmbS-PBouEXaddhkcW-10VAe4LXH9YL9ZWTdA2b9zyi-AVvbnxwhAgAA',
        ]);
        $factory->setCallbackData([
            'emailCallback' => function($email, $style = null){
                $value = $email;
                $display = 'style="display:' . ['none',' none'][random_int(0,1)] . '"';
                $style = $style ?? random_int(0,5);
                $props[] = "href=\"mailto:$email\"";
        
                $wrap = function($value, $style) use($display){
                    switch($style){
                        case 2: return "<!-- $value -->";
                        case 4: return "<span $display>$value</span>";
                        case 5:
                            $id = '41t2chali88';
                            return "<div id=\"$id\">$value</div>\n<script>document.getElementById('$id').innerHTML = '';</script>";
                        default: return $value;
                    }
                };
        
                switch($style){
                    case 0: $value = ''; break;
                    case 3: $value = $wrap($email, 2); break;
                    case 1: $props[] = $display; break;
                }
        
                $props = implode(' ', $props);
                $link = "<a $props>$value</a>";
        
                return $wrap($link, $style);
            }
        ]);

        $transcriber = new DataTranscriber($templateData, $factory);

        $template = new ArrayTemplate([
            'doctype',
            'injDocType',
            'head1',
            'injHead1HTMLMsg',
            'robots',
            'injRobotHTMLMsg',
            'nocollect',
            'injNoCollectHTMLMsg',
            'head2',
            'injHead2HTMLMsg',
            'top',
            'injTopHTMLMsg',
            'actMsg',
            'errMsg',
            'customMsg',
            'legal',
            'injLegalHTMLMsg',
            'altLegalMsg',
            'emailCallback',
            'injEmailHTMLMsg',
            'style',
            'injStyleHTMLMsg',
            'vanity',
            'injVanityHTMLMsg',
            'altVanityMsg',
            'bottom',
            'injBottomHTMLMsg',
        ]);

        $hp = new Script($client, $transcriber, $template, $templateData, $factory);
        $hp->handle($host, $port, $script);
    }

    public function handle($host, $port, $script)
    {
        $data = [
            'tag1' => '18a0cd8d8a4f362c34a0b52a44e9d7a3',
            'tag2' => '309d5001fd1f1bd8c59e7a36dbb83705',
            'tag3' => '3649d4e9bcfd3422fb4f9d22ae0a2a91',
            'tag4' => md5_file(__FILE__),
            'version' => "php-".phpversion(),
            'ip'      => $_SERVER['REMOTE_ADDR'],
            'svrn'    => $_SERVER['SERVER_NAME'],
            'svp'     => $_SERVER['SERVER_PORT'],
            'sn'      => $_SERVER['SCRIPT_NAME']     ?? '',
            'svip'    => $_SERVER['SERVER_ADDR']     ?? '',
            'rquri'   => $_SERVER['REQUEST_URI']     ?? '',
            'phpself' => $_SERVER['PHP_SELF']        ?? '',
            'ref'     => $_SERVER['HTTP_REFERER']    ?? '',
            'uagnt'   => $_SERVER['HTTP_USER_AGENT'] ?? '',
        ];

        $headers = [
            "User-Agent: PHPot {$data['tag2']}",
            "Content-Type: application/x-www-form-urlencoded",
            "Cache-Control: no-store, no-cache",
            "Accept: */*",
            "Pragma: no-cache",
        ];

        $subResponse = $this->client->request("POST", "http://$host:$port/$script", $headers, $data);
        $data = $this->transcriber->transcribe($subResponse->getLines());
        $response = new TextResponse($this->template->render($data));

        $this->serve($response);
    }

    public function serve(Response $response)
    {
        header("Cache-Control: no-store, no-cache");
        header("Pragma: no-cache");

        print $response->getBody();
    }
}

Script::run(__REQUEST_HOST, __REQUEST_PORT, __REQUEST_SCRIPT, __DIR__ . '/phpot_settings.php');

