w = document.getElementById('findipwidget');
h = '<style>#findipinfo div {display: inline-block;margin: 0 6px 0 0}#findipinfo img {	box-shadow: 1px 1px 3px #666;	border: 0;	display: inline}a#findipinfo {	display: block;	width: 733px;	text-align: center;	color: #444;text-decoration: none;background: #fcfcfc;padding: 10px;overflow: hidden;line-height: 170%;box-sizing: content-box;}a#findipinfo:hover {background: #fafafa;color: #111;}.findiplink {	padding: 2px 8px;	text-align: right;	width: 737px;	font-size: 11px;	border-top: 0;	overflow: hidden;	line-height: 150%;	color: #555;	background: #fff;	box-sizing: content-box;}.findiplink a {text-decoration: none;}</style><p><div>Your IP: <b>176.57.138.63</b></div><div>Country: <b>Germany</b></div><div>Region: <b>Hesse</b></div><div>City: <b>Frankfurt am Main</b></div><div>Language: <b>en-GB</b></div><div>Browser: <b>Firefox</b></div><div>System: <b>Windows 10</b></div></p>'
if (w) {
	u = document.getElementById('findipurl');
	if (u) {
		w.innerHTML = h;
	}
} else {
	document.write(h);
}

