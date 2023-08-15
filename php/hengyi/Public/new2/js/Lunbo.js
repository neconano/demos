
function LbMove(boxID, btn_left, btn_right, btnBox, Car, direction, way, moveLengh, speed, Interval, number) {
	var _ID = $("#" + boxID + "");
	var _btnBox = $("#" + btnBox + "");
	var jsq = 0
	var timer;
	var cj;
	var new_time = new Date;

	var ID_liLen, ID_liheight, cbtmBtn;
	ID_liLen = _ID.find("li").length;
	ID_liheight = _ID.find("li").innerHeight();
	_ID.find("ul").width(ID_liLen * moveLengh);
	_btnBox.empty();
	for (i = 0; i < ID_liLen ; i++) {
		_btnBox.append("<span></span>");
	};
	_btnBox.find("span").eq(0).addClass("cur");

	function Carousel() {
			_ID.find("ul").animate({
				left: -moveLengh
			}, speed, function () {
				console.log(1)
				_ID.find("li:first").insertAfter(_ID.find("li:last"));
				_ID.find("ul").css({
					"left": 0
				});
			});
			if (jsq < ID_liLen - 1) {
				jsq++;
				_btnBox.find("span").eq(jsq).addClass("cur").siblings().removeClass("cur");
			} else {
				jsq = 0;
				_btnBox.find("span").eq(jsq).addClass("cur").siblings().removeClass("cur");
			}
	}


	if (ID_liLen > number) {
		timer = setInterval(Carousel, Interval);
	} else {
		clearInterval(timer);
		_btnBox.hide();
	}


	_btnBox.find("span").hover(function () {
		clearInterval(timer);
	}, function () {
		if (ID_liLen > number) {
			timer = setInterval(Carousel, Interval);
		} else {
			clearInterval(timer);
			_btnBox.hide();
		}
	}).click(function () {
		if (new Date - new_time > 1000) {
				new_time = new Date;
				cbtmBtn = $(this).index();
				$(this).addClass("cur").siblings().removeClass("cur");
				if (cbtmBtn > jsq) {
					cj = cbtmBtn - jsq;
					jsq = cbtmBtn;
					_ID.find("ul").stop().animate({
						left: -moveLengh * cj
					}, speed, function () {
						for (i = 0; i < cj; i++) {
							_ID.find("ul").css({
								"left": 0
							})
							_ID.find("li:first").insertAfter(_ID.find("li:last"));
						};
					});
				} else {
					cj = jsq - cbtmBtn;
					jsq = cbtmBtn;
					_ID.find("ul").css({
						"left": -moveLengh * cj
					});
					for (i = 0; i < cj; i++) {
						_ID.find("ul").stop().animate({
							left: 0
						}, speed);
						_ID.find("li:last").insertBefore(_ID.find("li:first"));
					};
				};
		} else {};
	});

}


