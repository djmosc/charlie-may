/* Load this script using conditional IE comments if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'icons\'">' + entity + '</span>' + html;
	}
	var icons = {
			'icon-search' : '&#x31;',
			'icon-envelope' : '&#x32;',
			'icon-heart' : '&#x33;',
			'icon-th-large' : '&#x34;',
			'icon-th' : '&#x35;',
			'icon-th-list' : '&#x36;',
			'icon-ok' : '&#x37;',
			'icon-remove' : '&#x38;',
			'icon-zoom-in' : '&#x39;',
			'icon-zoom-out' : '&#x30;',
			'icon-chevron-left' : '&#x71;',
			'icon-chevron-right' : '&#x77;',
			'icon-chevron-up' : '&#xf077;',
			'icon-chevron-down' : '&#x65;',
			'icon-twitter' : '&#x72;',
			'icon-facebook' : '&#x74;',
			'icon-pinterest' : '&#x79;',
			'icon-google-plus' : '&#x75;',
			'icon-linkedin' : '&#x69;',
			'icon-youtube' : '&#x6f;',
			'icon-instagram' : '&#x70;',
			'icon-tumblr' : '&#x61;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, html, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
};