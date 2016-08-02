/* Load this script using conditional IE comments if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'pixons\'">' + entity + '</span>' + html;
	}
	var icons = {
			'pixons-amazon' : '&#x21;',
			'pixons-android' : '&#x22;',
			'pixons-aol' : '&#x23;',
			'pixons-behance' : '&#x24;',
			'pixons-bing' : '&#x25;',
			'pixons-blogger' : '&#x26;',
			'pixons-buzz' : '&#x27;',
			'pixons-delicious' : '&#x28;',
			'pixons-deviantart' : '&#x29;',
			'pixons-digg' : '&#x2a;',
			'pixons-dribbble' : '&#x2b;',
			'pixons-dropbox' : '&#x2c;',
			'pixons-drupal' : '&#x2d;',
			'pixons-ember' : '&#x2e;',
			'pixons-envato' : '&#x2f;',
			'pixons-evernote' : '&#x30;',
			'pixons-facebook-1' : '&#x31;',
			'pixons-facebook-2' : '&#x32;',
			'pixons-feedburner' : '&#x33;',
			'pixons-forrst' : '&#x34;',
			'pixons-foursquare' : '&#x35;',
			'pixons-github' : '&#x36;',
			'pixons-google_plus' : '&#x37;',
			'pixons-grooveshark' : '&#x38;',
			'pixons-html5' : '&#x39;',
			'pixons-instagram' : '&#x3a;',
			'pixons-lastfm' : '&#x3b;',
			'pixons-linkedin' : '&#x3c;',
			'pixons-metacafe' : '&#x3d;',
			'pixons-mixx' : '&#x3e;',
			'pixons-myspace' : '&#x3f;',
			'pixons-newsvine' : '&#x40;',
			'pixons-paypal' : '&#x41;',
			'pixons-picasa' : '&#x42;',
			'pixons-pinterest' : '&#x43;',
			'pixons-plixi' : '&#x44;',
			'pixons-plurk' : '&#x45;',
			'pixons-posterous' : '&#x46;',
			'pixons-reddit' : '&#x47;',
			'pixons-rss' : '&#x48;',
			'pixons-sharethis' : '&#x49;',
			'pixons-skype' : '&#x4a;',
			'pixons-stumbleupon' : '&#x4b;',
			'pixons-technorati' : '&#x4c;',
			'pixons-tumblr' : '&#x4d;',
			'pixons-twitter-1' : '&#x4e;',
			'pixons-twitter-2' : '&#x4f;',
			'pixons-vimeo' : '&#x50;',
			'pixons-wordpress' : '&#x51;',
			'pixons-xing' : '&#x52;',
			'pixons-yahoo' : '&#x53;',
			'pixons-yelp' : '&#x54;',
			'pixons-youtube' : '&#x55;',
			'pixons-zerply' : '&#x56;',
			'pixons-zootool' : '&#x57;',
			'pixons-github-2' : '&#x58;',
			'pixons-soundcloud' : '&#x59;',
			'pixons-flickr' : '&#x5a;',
			'pixons-apple' : '&#x5b;',
			'pixons-tux' : '&#x5c;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, html, c, el;
	for (i = 0; i < els.length; i += 1) {
		el = els[i];
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/pixons-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
};