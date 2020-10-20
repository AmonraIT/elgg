<?php

return array(
	'admin:inbox' => 'Inbox',
	'admin:inbox:monitor' => 'Inbox Monitor',
	'inbox:monitor:no_results' => 'There are no messages to display',

	'inbox:monitor:blacklist' => 'Blacklisted words',
	'inbox:monitor:blacklist:help' => 'List words that should be considered suspicious (one per line)',

	'inbox:monitor:policy' => 'Blacklist Policy',
	'inbox:minitor:policy:help' => 'What should we do with the blacklisted words found in messages?',
	'inbox:monitor:policy:nothing' => 'Do nothing',
	'inbox:monitor:policy:mask' => 'Mask (i.e. f**k)',
	'inbox:monitor:policy:silence' => 'Add CSS styles to make them barely visible',
	'inbox:monitor:policy:remove' => 'Remove (i.e. [removed])',
	'inbox:monitor:removed' => 'removed',

	'inbox:monitor:subtitle' => 'Sent by %s to %s %s',
	'inbox:monitor:view_all' => 'Show message',
	'inbox:monitor:toggle' => 'Toggle All',

	'inbox:monitor:delete' => 'Delete',
	'inbox:monitor:delete:error' => 'Messages could not be deleted',
	'inbox:monitor:delete:partial_success' => '%s of %s messages were deleted',
	'inbox:monitor:delete:success' => 'Messages were deleted successfully',

	'inbox:monitor:flagged' => 'Message has been redacted as it contains words disallowed by site policy. Please treat this message as suspicious and do not provide any personal information in response.',
);