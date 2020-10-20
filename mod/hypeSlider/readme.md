hypeSlider
=========
![Elgg 3.0](https://img.shields.io/badge/Elgg-3.0.x-orange.svg?style=flat-square)

Responsive slider based on Slick.js

## Screenshots ##
![Video slide](https://raw.github.com/hypeJunction/elgg_slider/master/screenshots/slick.png "Slick Slider")
![Image slide](https://raw.github.com/hypeJunction/elgg_slider/master/screenshots/slick2.png "Slick Slider")


## Add a slider

To add a new slider to a page:

```php
echo elgg_view('page/components/slider', array(
	// An array of slides
	'slides' => array(
		0 => elgg_view('my/awesome/slide', array(
			'headline' => 'Best headline ever',
		)),
		1 => elgg_view('output/img', array(
			'src' => 'http://www.menucool.com/slider/jsImgSlider/images/image-slider-1.jpg',
		)),
		2 => elgg_view('output/img', array(
			'src' => 'http://www.menucool.com/slider/jsImgSlider/images/image-slider-2.jpg',
		)),
		3 => elgg_view('output/img', array(
			'src' => 'http://www.menucool.com/slider/jsImgSlider/images/image-slider-3.jpg',
		)),
		4 => elgg_format_element('iframe', array(
			'src' => 'https://player.vimeo.com/video/3689348',
			'height' => 306,
			'width' => 700,
			'frameborder' => 0,
			'webkitallowfullscreen' => true,
			'mozallowfullscreen' => true,
			'allowfullscreen' => true,
		))
	),

	// Slick slider settings
	'slick' => array(
		'slidesToShow' => 2,
		'slidesToScroll' => 1,
		'speed' => 500,
		'dots' => true,
		'autoplay' => true,
		'autoplaySpeed' => 2000,
	),
));
```

## Notes

* For a full list of slick slider settings, see:
http://kenwheeler.github.io/slick/

