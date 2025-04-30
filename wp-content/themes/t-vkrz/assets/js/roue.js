/*!
 * Draggable 3.9.1
 * https://greensock.com
 *
 * @license Copyright 2021, GreenSock. All rights reserved.
 * Subject to the terms at https://greensock.com/standard-license or for Club GreenSock members, the agreement issued with that membership.
 * @author: Jack Doyle, jack@greensock.com
 */

!(function (e, t) {
	"object" == typeof exports && "undefined" != typeof module
		? t(exports)
		: "function" == typeof define && define.amd
		? define(["exports"], t)
		: t(((e = e || self).window = e.window || {}));
})(this, function (e) {
	"use strict";
	function w(e, t) {
		if (e.parentNode && (h || T(e))) {
			var n = C(e),
				o = n
					? n.getAttribute("xmlns") || "http://www.w3.org/2000/svg"
					: "http://www.w3.org/1999/xhtml",
				r = n ? (t ? "rect" : "g") : "div",
				i = 2 !== t ? 0 : 100,
				a = 3 === t ? 100 : 0,
				l =
					"position:absolute;display:block;pointer-events:none;margin:0;padding:0;",
				s = h.createElementNS
					? h.createElementNS(o.replace(/^https/, "http"), r)
					: h.createElement(r);
			return (
				t &&
					(n
						? ((g = g || w(e)),
						  s.setAttribute("width", 0.01),
						  s.setAttribute("height", 0.01),
						  s.setAttribute("transform", "translate(" + i + "," + a + ")"),
						  g.appendChild(s))
						: (f || ((f = w(e)).style.cssText = l),
						  (s.style.cssText =
								l +
								"width:0.1px;height:0.1px;top:" +
								a +
								"px;left:" +
								i +
								"px"),
						  f.appendChild(s))),
				s
			);
		}
		throw "Need document and parent.";
	}
	function A(e, t, n, o, r, i, a) {
		return (e.a = t), (e.b = n), (e.c = o), (e.d = r), (e.e = i), (e.f = a), e;
	}
	var h,
		p,
		r,
		i,
		f,
		g,
		x,
		m,
		y,
		t,
		v = "transform",
		b = v + "Origin",
		T = function _setDoc(e) {
			var t = e.ownerDocument || e;
			!(v in e.style) &&
				"msTransform" in e.style &&
				(b = (v = "msTransform") + "Origin");
			for (; t.parentNode && (t = t.parentNode); );
			if (((p = window), (x = new fe()), t)) {
				(r = (h = t).documentElement),
					(i = t.body),
					((m = h.createElementNS(
						"http://www.w3.org/2000/svg",
						"g"
					)).style.transform = "none");
				var n = t.createElement("div"),
					o = t.createElement("div");
				i.appendChild(n),
					n.appendChild(o),
					(n.style.position = "static"),
					(n.style[v] = "translate3d(0,0,1px)"),
					(y = o.offsetParent !== n),
					i.removeChild(n);
			}
			return t;
		},
		D = function _forceNonZeroScale(e) {
			for (var t, n; e && e !== i; )
				(n = e._gsap) && n.uncache && n.get(e, "x"),
					n &&
						!n.scaleX &&
						!n.scaleY &&
						n.renderTransform &&
						((n.scaleX = n.scaleY = 1e-4),
						n.renderTransform(1, n),
						t ? t.push(n) : (t = [n])),
					(e = e.parentNode);
			return t;
		},
		E = [],
		M = [],
		L = function _getDocScrollTop() {
			return p.pageYOffset || h.scrollTop || r.scrollTop || i.scrollTop || 0;
		},
		S = function _getDocScrollLeft() {
			return p.pageXOffset || h.scrollLeft || r.scrollLeft || i.scrollLeft || 0;
		},
		C = function _svgOwner(e) {
			return (
				e.ownerSVGElement ||
				("svg" === (e.tagName + "").toLowerCase() ? e : null)
			);
		},
		N = function _isFixed(e) {
			return (
				"fixed" === p.getComputedStyle(e).position ||
				((e = e.parentNode) && 1 === e.nodeType ? _isFixed(e) : void 0)
			);
		},
		O = function _placeSiblings(e, t) {
			var n,
				o,
				r,
				i,
				a,
				l,
				s = C(e),
				c = e === s,
				d = s ? E : M,
				u = e.parentNode;
			if (e === p) return e;
			if ((d.length || d.push(w(e, 1), w(e, 2), w(e, 3)), (n = s ? g : f), s))
				c
					? ((i =
							-(r = (function _getCTM(e) {
								var t,
									n = e.getCTM();
								return (
									n ||
										((t = e.style[v]),
										(e.style[v] = "none"),
										e.appendChild(m),
										(n = m.getCTM()),
										e.removeChild(m),
										t
											? (e.style[v] = t)
											: e.style.removeProperty(
													v.replace(/([A-Z])/g, "-$1").toLowerCase()
											  )),
									n || x.clone()
								);
							})(e)).e / r.a),
					  (a = -r.f / r.d),
					  (o = x))
					: ((r = e.getBBox()),
					  (i =
							(o = (o = e.transform ? e.transform.baseVal : {}).numberOfItems
								? 1 < o.numberOfItems
									? (function _consolidate(e) {
											for (var t = new fe(), n = 0; n < e.numberOfItems; n++)
												t.multiply(e.getItem(n).matrix);
											return t;
									  })(o)
									: o.getItem(0).matrix
								: x).a *
								r.x +
							o.c * r.y),
					  (a = o.b * r.x + o.d * r.y)),
					t && "g" === e.tagName.toLowerCase() && (i = a = 0),
					(c ? s : u).appendChild(n),
					n.setAttribute(
						"transform",
						"matrix(" +
							o.a +
							"," +
							o.b +
							"," +
							o.c +
							"," +
							o.d +
							"," +
							(o.e + i) +
							"," +
							(o.f + a) +
							")"
					);
			else {
				if (((i = a = 0), y))
					for (
						o = e.offsetParent, r = e;
						(r = r && r.parentNode) && r !== o && r.parentNode;

					)
						4 < (p.getComputedStyle(r)[v] + "").length &&
							((i = r.offsetLeft), (a = r.offsetTop), (r = 0));
				if (
					"absolute" !== (l = p.getComputedStyle(e)).position &&
					"fixed" !== l.position
				)
					for (o = e.offsetParent; u && u !== o; )
						(i += u.scrollLeft || 0),
							(a += u.scrollTop || 0),
							(u = u.parentNode);
				((r = n.style).top = e.offsetTop - a + "px"),
					(r.left = e.offsetLeft - i + "px"),
					(r[v] = l[v]),
					(r[b] = l[b]),
					(r.position = "fixed" === l.position ? "fixed" : "absolute"),
					e.parentNode.appendChild(n);
			}
			return n;
		},
		fe =
			(((t = Matrix2D.prototype).inverse = function inverse() {
				var e = this.a,
					t = this.b,
					n = this.c,
					o = this.d,
					r = this.e,
					i = this.f,
					a = e * o - t * n || 1e-10;
				return A(
					this,
					o / a,
					-t / a,
					-n / a,
					e / a,
					(n * i - o * r) / a,
					-(e * i - t * r) / a
				);
			}),
			(t.multiply = function multiply(e) {
				var t = this.a,
					n = this.b,
					o = this.c,
					r = this.d,
					i = this.e,
					a = this.f,
					l = e.a,
					s = e.c,
					c = e.b,
					d = e.d,
					u = e.e,
					p = e.f;
				return A(
					this,
					l * t + c * o,
					l * n + c * r,
					s * t + d * o,
					s * n + d * r,
					i + u * t + p * o,
					a + u * n + p * r
				);
			}),
			(t.clone = function clone() {
				return new Matrix2D(this.a, this.b, this.c, this.d, this.e, this.f);
			}),
			(t.equals = function equals(e) {
				var t = this.a,
					n = this.b,
					o = this.c,
					r = this.d,
					i = this.e,
					a = this.f;
				return (
					t === e.a &&
					n === e.b &&
					o === e.c &&
					r === e.d &&
					i === e.e &&
					a === e.f
				);
			}),
			(t.apply = function apply(e, t) {
				void 0 === t && (t = {});
				var n = e.x,
					o = e.y,
					r = this.a,
					i = this.b,
					a = this.c,
					l = this.d,
					s = this.e,
					c = this.f;
				return (
					(t.x = n * r + o * a + s || 0), (t.y = n * i + o * l + c || 0), t
				);
			}),
			Matrix2D);
	function Matrix2D(e, t, n, o, r, i) {
		void 0 === e && (e = 1),
			void 0 === t && (t = 0),
			void 0 === n && (n = 0),
			void 0 === o && (o = 1),
			void 0 === r && (r = 0),
			void 0 === i && (i = 0),
			A(this, e, t, n, o, r, i);
	}
	function getGlobalMatrix(e, t, n, o) {
		if (!e || !e.parentNode || (h || T(e)).documentElement === e)
			return new fe();
		var r = D(e),
			i = C(e) ? E : M,
			a = O(e, n),
			l = i[0].getBoundingClientRect(),
			s = i[1].getBoundingClientRect(),
			c = i[2].getBoundingClientRect(),
			d = a.parentNode,
			u = !o && N(e),
			p = new fe(
				(s.left - l.left) / 100,
				(s.top - l.top) / 100,
				(c.left - l.left) / 100,
				(c.top - l.top) / 100,
				l.left + (u ? 0 : S()),
				l.top + (u ? 0 : L())
			);
		if ((d.removeChild(a), r))
			for (l = r.length; l--; )
				((s = r[l]).scaleX = s.scaleY = 0), s.renderTransform(1, s);
		return t ? p.inverse() : p;
	}
	function V() {
		return "undefined" != typeof window;
	}
	function W() {
		return ge || (V() && (ge = window.gsap) && ge.registerPlugin && ge);
	}
	function X(e) {
		return "function" == typeof e;
	}
	function Y(e) {
		return "object" == typeof e;
	}
	function Z(e) {
		return void 0 === e;
	}
	function $() {
		return !1;
	}
	function ba(e) {
		return Math.round(1e4 * e) / 1e4;
	}
	function da(e, t) {
		var n = me.createElementNS
			? me.createElementNS(
					(t || "http://www.w3.org/1999/xhtml").replace(/^https/, "http"),
					e
			  )
			: me.createElement(e);
		return n.style ? n : me.createElement(e);
	}
	function pa(e, t) {
		var n,
			o = {};
		for (n in e) o[n] = t ? e[n] * t : e[n];
		return o;
	}
	function ra(e, t) {
		for (var n, o = e.length; o--; )
			t
				? (e[o].style.touchAction = t)
				: e[o].style.removeProperty("touch-action"),
				(n = e[o].children) && n.length && ra(n, t);
	}
	function sa() {
		return _e.forEach(function (e) {
			return e();
		});
	}
	function ua() {
		return !_e.length && ge.ticker.remove(sa);
	}
	function va(e) {
		for (var t = _e.length; t--; ) _e[t] === e && _e.splice(t, 1);
		ge.to(ua, {
			overwrite: !0,
			delay: 15,
			duration: 0,
			onComplete: ua,
			data: "_draggable",
		});
	}
	function xa(e, t, n, o) {
		if (e.addEventListener) {
			var r = De[t];
			(o = o || (d ? { passive: !1 } : null)),
				e.addEventListener(r || t, n, o),
				r && t !== r && e.addEventListener(t, n, o);
		}
	}
	function ya(e, t, n) {
		if (e.removeEventListener) {
			var o = De[t];
			e.removeEventListener(o || t, n),
				o && t !== o && e.removeEventListener(t, n);
		}
	}
	function za(e) {
		e.preventDefault && e.preventDefault(),
			e.preventManipulation && e.preventManipulation();
	}
	function Ba(e) {
		(Me = e.touches && Ee < e.touches.length), ya(e.target, "touchend", Ba);
	}
	function Ca(e) {
		(Me = e.touches && Ee < e.touches.length), xa(e.target, "touchend", Ba);
	}
	function Da(e) {
		return (
			xe.pageYOffset ||
			e.scrollTop ||
			e.documentElement.scrollTop ||
			e.body.scrollTop ||
			0
		);
	}
	function Ea(e) {
		return (
			xe.pageXOffset ||
			e.scrollLeft ||
			e.documentElement.scrollLeft ||
			e.body.scrollLeft ||
			0
		);
	}
	function Fa(e, t) {
		xa(e, "scroll", t), Fe(e.parentNode) || Fa(e.parentNode, t);
	}
	function Ga(e, t) {
		ya(e, "scroll", t), Fe(e.parentNode) || Ga(e.parentNode, t);
	}
	function Ia(e, t) {
		var n = "x" === t ? "Width" : "Height",
			o = "scroll" + n,
			r = "client" + n;
		return Math.max(
			0,
			Fe(e)
				? Math.max(ye[o], l[o]) - (xe["inner" + n] || ye[r] || l[r])
				: e[o] - e[r]
		);
	}
	function Ja(e, t) {
		var n = Ia(e, "x"),
			o = Ia(e, "y");
		Fe(e) ? (e = He) : Ja(e.parentNode, t),
			(e._gsMaxScrollX = n),
			(e._gsMaxScrollY = o),
			t ||
				((e._gsScrollX = e.scrollLeft || 0), (e._gsScrollY = e.scrollTop || 0));
	}
	function Ka(e, t, n) {
		var o = e.style;
		o &&
			(Z(o[t]) && (t = c(t, e) || t),
			null == n
				? o.removeProperty &&
				  o.removeProperty(t.replace(/([A-Z])/g, "-$1").toLowerCase())
				: (o[t] = n));
	}
	function La(e) {
		return xe.getComputedStyle(
			e instanceof Element ? e : e.host || (e.parentNode || {}).host || e
		);
	}
	function Na(e) {
		if (e === xe)
			return (
				(u.left = u.top = 0),
				(u.width = u.right =
					ye.clientWidth || e.innerWidth || l.clientWidth || 0),
				(u.height = u.bottom =
					(e.innerHeight || 0) - 20 < ye.clientHeight
						? ye.clientHeight
						: e.innerHeight || l.clientHeight || 0),
				u
			);
		var t = e.ownerDocument || me,
			n = Z(e.pageX)
				? e.nodeType || Z(e.left) || Z(e.top)
					? be(e)[0].getBoundingClientRect()
					: e
				: {
						left: e.pageX - Ea(t),
						top: e.pageY - Da(t),
						right: e.pageX - Ea(t) + 1,
						bottom: e.pageY - Da(t) + 1,
				  };
		return (
			Z(n.right) && !Z(n.width)
				? ((n.right = n.left + n.width), (n.bottom = n.top + n.height))
				: Z(n.width) &&
				  (n = {
						width: n.right - n.left,
						height: n.bottom - n.top,
						right: n.right,
						left: n.left,
						bottom: n.bottom,
						top: n.top,
				  }),
			n
		);
	}
	function Oa(e, t, n) {
		var o,
			r = e.vars,
			i = r[n],
			a = e._listeners[t];
		return (
			X(i) &&
				(o = i.apply(
					r.callbackScope || e,
					r[n + "Params"] || [e.pointerEvent]
				)),
			a && !1 === e.dispatchEvent(t) && (o = !1),
			o
		);
	}
	function Pa(e, t) {
		var n,
			o,
			r,
			i = be(e)[0];
		return i.nodeType || i === xe
			? R(i, t)
			: Z(e.left)
			? {
					left: (o = e.min || e.minX || e.minRotation || 0),
					top: (n = e.min || e.minY || 0),
					width: (e.max || e.maxX || e.maxRotation || 0) - o,
					height: (e.max || e.maxY || 0) - n,
			  }
			: ((r = { x: 0, y: 0 }),
			  {
					left: e.left - r.x,
					top: e.top - r.y,
					width: e.width,
					height: e.height,
			  });
	}
	function Sa(r, i, e, t, a, n) {
		var o,
			l,
			s,
			c = {};
		if (i)
			if (1 !== a && i instanceof Array) {
				if (((c.end = o = []), (s = i.length), Y(i[0])))
					for (l = 0; l < s; l++) o[l] = pa(i[l], a);
				else for (l = 0; l < s; l++) o[l] = i[l] * a;
				(e += 1.1), (t -= 1.1);
			} else
				X(i)
					? (c.end = function (e) {
							var t,
								n,
								o = i.call(r, e);
							if (1 !== a)
								if (Y(o)) {
									for (n in ((t = {}), o)) t[n] = o[n] * a;
									o = t;
								} else o *= a;
							return o;
					  })
					: (c.end = i);
		return (
			(!e && 0 !== e) || (c.max = e),
			(!t && 0 !== t) || (c.min = t),
			n && (c.velocity = 0),
			c
		);
	}
	function Ta(e) {
		var t;
		return (
			!(!e || !e.getAttribute || e === l) &&
			(!(
				"true" !== (t = e.getAttribute("data-clickable")) &&
				("false" === t ||
					(!e.onclick &&
						!o.test(e.nodeName + "") &&
						"true" !== e.getAttribute("contentEditable")))
			) ||
				Ta(e.parentNode))
		);
	}
	function Ua(e, t) {
		for (var n, o = e.length; o--; )
			((n = e[o]).ondragstart = n.onselectstart = t ? null : $),
				ge.set(n, { lazy: !0, userSelect: t ? "text" : "none" });
	}
	function Ya(i, r) {
		(i = ge.utils.toArray(i)[0]), (r = r || {});
		var a,
			l,
			s,
			e,
			c,
			d,
			u = document.createElement("div"),
			p = u.style,
			t = i.firstChild,
			h = 0,
			f = 0,
			g = i.scrollTop,
			x = i.scrollLeft,
			m = i.scrollWidth,
			y = i.scrollHeight,
			v = 0,
			w = 0,
			b = 0;
		P && !1 !== r.force3D
			? ((c = "translate3d("), (d = "px,0px)"))
			: _ && ((c = "translate("), (d = "px)")),
			(this.scrollTop = function (e, t) {
				if (!arguments.length) return -this.top();
				this.top(-e, t);
			}),
			(this.scrollLeft = function (e, t) {
				if (!arguments.length) return -this.left();
				this.left(-e, t);
			}),
			(this.left = function (e, t) {
				if (!arguments.length) return -(i.scrollLeft + f);
				var n = i.scrollLeft - x,
					o = f;
				if ((2 < n || n < -2) && !t)
					return (
						(x = i.scrollLeft),
						ge.killTweensOf(this, { left: 1, scrollLeft: 1 }),
						this.left(-x),
						void (r.onKill && r.onKill())
					);
				(e = -e) < 0
					? ((f = (e - 0.5) | 0), (e = 0))
					: w < e
					? ((f = (e - w) | 0), (e = w))
					: (f = 0),
					(f || o) &&
						(this._skip || (p[_] = c + -f + "px," + -h + d),
						0 <= f + v && (p.paddingRight = f + v + "px")),
					(i.scrollLeft = 0 | e),
					(x = i.scrollLeft);
			}),
			(this.top = function (e, t) {
				if (!arguments.length) return -(i.scrollTop + h);
				var n = i.scrollTop - g,
					o = h;
				if ((2 < n || n < -2) && !t)
					return (
						(g = i.scrollTop),
						ge.killTweensOf(this, { top: 1, scrollTop: 1 }),
						this.top(-g),
						void (r.onKill && r.onKill())
					);
				(e = -e) < 0
					? ((h = (e - 0.5) | 0), (e = 0))
					: b < e
					? ((h = (e - b) | 0), (e = b))
					: (h = 0),
					(h || o) && (this._skip || (p[_] = c + -f + "px," + -h + d)),
					(i.scrollTop = 0 | e),
					(g = i.scrollTop);
			}),
			(this.maxScrollTop = function () {
				return b;
			}),
			(this.maxScrollLeft = function () {
				return w;
			}),
			(this.disable = function () {
				for (t = u.firstChild; t; )
					(e = t.nextSibling), i.appendChild(t), (t = e);
				i === u.parentNode && i.removeChild(u);
			}),
			(this.enable = function () {
				if ((t = i.firstChild) !== u) {
					for (; t; ) (e = t.nextSibling), u.appendChild(t), (t = e);
					i.appendChild(u), this.calibrate();
				}
			}),
			(this.calibrate = function (e) {
				var t,
					n,
					o,
					r = i.clientWidth === a;
				(g = i.scrollTop),
					(x = i.scrollLeft),
					(r &&
						i.clientHeight === l &&
						u.offsetHeight === s &&
						m === i.scrollWidth &&
						y === i.scrollHeight &&
						!e) ||
						((h || f) &&
							((n = this.left()),
							(o = this.top()),
							this.left(-i.scrollLeft),
							this.top(-i.scrollTop)),
						(t = La(i)),
						(r && !e) ||
							((p.display = "block"),
							(p.width = "auto"),
							(p.paddingRight = "0px"),
							(v = Math.max(0, i.scrollWidth - i.clientWidth)) &&
								(v +=
									parseFloat(t.paddingLeft) +
									(k ? parseFloat(t.paddingRight) : 0))),
						(p.display = "inline-block"),
						(p.position = "relative"),
						(p.overflow = "visible"),
						(p.verticalAlign = "top"),
						(p.boxSizing = "content-box"),
						(p.width = "100%"),
						(p.paddingRight = v + "px"),
						k && (p.paddingBottom = t.paddingBottom),
						(a = i.clientWidth),
						(l = i.clientHeight),
						(m = i.scrollWidth),
						(y = i.scrollHeight),
						(w = i.scrollWidth - a),
						(b = i.scrollHeight - l),
						(s = u.offsetHeight),
						(p.display = "block"),
						(n || o) && (this.left(n), this.top(o)));
			}),
			(this.content = u),
			(this.element = i),
			(this._skip = !1),
			this.enable();
	}
	function Za(e) {
		if (V() && document.body) {
			var t = window && window.navigator;
			(xe = window),
				(me = document),
				(ye = me.documentElement),
				(l = me.body),
				(s = da("div")),
				(Ye = !!window.PointerEvent),
				((ve = da("div")).style.cssText =
					"visibility:hidden;height:1px;top:-1px;pointer-events:none;position:relative;clear:both;cursor:grab"),
				(Se = "grab" === ve.style.cursor ? "grab" : "move"),
				(Xe = t && -1 !== t.userAgent.toLowerCase().indexOf("android")),
				(Te =
					("ontouchstart" in ye && "orientation" in xe) ||
					(t && (0 < t.MaxTouchPoints || 0 < t.msMaxTouchPoints))),
				(o = da("div")),
				(r = da("div")),
				(i = r.style),
				(a = l),
				(i.display = "inline-block"),
				(i.position = "relative"),
				(o.style.cssText = r.innerHTML =
					"width:90px;height:40px;padding:10px;overflow:auto;visibility:hidden"),
				o.appendChild(r),
				a.appendChild(o),
				(n = r.offsetHeight + 18 > o.scrollHeight),
				a.removeChild(o),
				(k = n),
				(De = (function (e) {
					for (
						var t = e.split(","),
							n = (
								("onpointerdown" in s)
									? "pointerdown,pointermove,pointerup,pointercancel"
									: ("onmspointerdown" in s)
									? "MSPointerDown,MSPointerMove,MSPointerUp,MSPointerCancel"
									: e
							).split(","),
							o = {},
							r = 4;
						-1 < --r;

					)
						(o[t[r]] = n[r]), (o[n[r]] = t[r]);
					try {
						ye.addEventListener(
							"test",
							null,
							Object.defineProperty({}, "passive", {
								get: function get() {
									d = 1;
								},
							})
						);
					} catch (e) {}
					return o;
				})("touchstart,touchmove,touchend,touchcancel")),
				xa(me, "touchcancel", $),
				xa(xe, "touchmove", $),
				l && l.addEventListener("touchstart", $),
				xa(me, "contextmenu", function () {
					for (var e in Re) Re[e].isPressed && Re[e].endDrag();
				}),
				(ge = we = W());
		}
		var n, o, r, i, a;
		ge
			? ((Le = ge.plugins.inertia),
			  (c = ge.utils.checkPrefix),
			  (_ = c(_)),
			  (Ce = c(Ce)),
			  (be = ge.utils.toArray),
			  (P = !!c("perspective")))
			: e && console.warn("Please gsap.registerPlugin(Draggable)");
	}
	var ge,
		xe,
		me,
		ye,
		l,
		s,
		ve,
		we,
		c,
		be,
		d,
		Te,
		De,
		Ee,
		Me,
		Xe,
		Le,
		Se,
		Ye,
		P,
		k,
		n,
		_ = "transform",
		Ce = "transformOrigin",
		Ne = Array.isArray,
		Oe = 180 / Math.PI,
		Pe = 1e20,
		a = new fe(),
		ke =
			Date.now ||
			function () {
				return new Date().getTime();
			},
		_e = [],
		Re = {},
		Ae = 0,
		o = /^(?:a|input|textarea|button|select)$/i,
		Be = 0,
		Ie = {},
		He = {},
		Fe = function _isRoot(e) {
			return !(
				e &&
				e !== ye &&
				9 !== e.nodeType &&
				e !== me.body &&
				e !== xe &&
				e.nodeType &&
				e.parentNode
			);
		},
		u = {},
		ze = {},
		R = function _getElementBounds(e, t) {
			t = be(t)[0];
			var n,
				o,
				r,
				i,
				a,
				l,
				s,
				c,
				d,
				u,
				p,
				h,
				f,
				g,
				x = e.getBBox && e.ownerSVGElement,
				m = e.ownerDocument || me;
			if (e === xe)
				(r = Da(m)),
					(o =
						(n = Ea(m)) +
						(m.documentElement.clientWidth ||
							e.innerWidth ||
							m.body.clientWidth ||
							0)),
					(i =
						r +
						((e.innerHeight || 0) - 20 < m.documentElement.clientHeight
							? m.documentElement.clientHeight
							: e.innerHeight || m.body.clientHeight || 0));
			else {
				if (t === xe || Z(t)) return e.getBoundingClientRect();
				(n = r = 0),
					x
						? ((p = (u = e.getBBox()).width), (h = u.height))
						: (e.viewBox &&
								(u = e.viewBox.baseVal) &&
								((n = u.x || 0), (r = u.y || 0), (p = u.width), (h = u.height)),
						  p ||
								((u = "border-box" === (f = La(e)).boxSizing),
								(p =
									(parseFloat(f.width) || e.clientWidth || 0) +
									(u
										? 0
										: parseFloat(f.borderLeftWidth) +
										  parseFloat(f.borderRightWidth))),
								(h =
									(parseFloat(f.height) || e.clientHeight || 0) +
									(u
										? 0
										: parseFloat(f.borderTopWidth) +
										  parseFloat(f.borderBottomWidth))))),
					(o = p),
					(i = h);
			}
			return e === t
				? { left: n, top: r, width: o - n, height: i - r }
				: ((l = (a = getGlobalMatrix(t, !0).multiply(getGlobalMatrix(e))).apply(
						{ x: n, y: r }
				  )),
				  (s = a.apply({ x: o, y: r })),
				  (c = a.apply({ x: o, y: i })),
				  (d = a.apply({ x: n, y: i })),
				  (n = Math.min(l.x, s.x, c.x, d.x)),
				  (r = Math.min(l.y, s.y, c.y, d.y)),
				  {
						left: n + ((g = t.parentNode || {}).scrollLeft || 0),
						top: r + (g.scrollTop || 0),
						width: Math.max(l.x, s.x, c.x, d.x) - n,
						height: Math.max(l.y, s.y, c.y, d.y) - r,
				  });
		},
		B =
			(((n = EventDispatcher.prototype).addEventListener =
				function addEventListener(e, t) {
					var n = this._listeners[e] || (this._listeners[e] = []);
					~n.indexOf(t) || n.push(t);
				}),
			(n.removeEventListener = function removeEventListener(e, t) {
				var n = this._listeners[e],
					o = (n && n.indexOf(t)) || -1;
				-1 < o && n.splice(o, 1);
			}),
			(n.dispatchEvent = function dispatchEvent(t) {
				var n,
					o = this;
				return (
					(this._listeners[t] || []).forEach(function (e) {
						return !1 === e.call(o, { type: t, target: o.target }) && (n = !1);
					}),
					n
				);
			}),
			EventDispatcher);
	function EventDispatcher(e) {
		(this._listeners = {}), (this.target = e || this);
	}
	var We,
		I =
			((function _inheritsLoose(e, t) {
				(e.prototype = Object.create(t.prototype)),
					((e.prototype.constructor = e).__proto__ = t);
			})(Draggable, (We = B)),
			(Draggable.register = function register(e) {
				(ge = e), Za();
			}),
			(Draggable.create = function create(e, t) {
				return (
					we || Za(!0),
					be(e).map(function (e) {
						return new Draggable(e, t);
					})
				);
			}),
			(Draggable.get = function get(e) {
				return Re[(be(e)[0] || {})._gsDragID];
			}),
			(Draggable.timeSinceDrag = function timeSinceDrag() {
				return (ke() - Be) / 1e3;
			}),
			(Draggable.hitTest = function hitTest(e, t, n) {
				if (e === t) return !1;
				var o,
					r,
					i,
					a = Na(e),
					l = Na(t),
					s = a.top,
					c = a.left,
					d = a.right,
					u = a.bottom,
					p = a.width,
					h = a.height,
					f = l.left > d || l.right < c || l.top > u || l.bottom < s;
				return f || !n
					? !f
					: ((i = -1 !== (n + "").indexOf("%")),
					  (n = parseFloat(n) || 0),
					  ((o = {
							left: Math.max(c, l.left),
							top: Math.max(s, l.top),
					  }).width = Math.min(d, l.right) - o.left),
					  (o.height = Math.min(u, l.bottom) - o.top),
					  !(o.width < 0 || o.height < 0) &&
							(i
								? p * h * (n *= 0.01) <= (r = o.width * o.height) ||
								  r >= l.width * l.height * n
								: o.width > n && o.height > n));
			}),
			Draggable);
	function Draggable(h, u) {
		var e;
		(e = We.call(this) || this),
			we || Za(1),
			(h = be(h)[0]),
			(Le = Le || ge.plugins.inertia),
			(e.vars = u = pa(u || {})),
			(e.target = h),
			(e.x = e.y = e.rotation = 0),
			(e.dragResistance = parseFloat(u.dragResistance) || 0),
			(e.edgeResistance = isNaN(u.edgeResistance)
				? 1
				: parseFloat(u.edgeResistance) || 0),
			(e.lockAxis = u.lockAxis),
			(e.autoScroll = u.autoScroll || 0),
			(e.lockedAxis = null),
			(e.allowEventDefault = !!u.allowEventDefault),
			ge.getProperty(h, "x");
		function Og(e, t) {
			return parseFloat(le.get(h, e, t));
		}
		function uh(e) {
			return (
				za(e), e.stopImmediatePropagation && e.stopImmediatePropagation(), !1
			);
		}
		function vh(e) {
			if (J.autoScroll && J.isDragging && (ee || O)) {
				var t,
					n,
					o,
					r,
					i,
					a,
					l,
					s,
					c = h,
					d = 15 * J.autoScroll;
				for (
					ee = !1,
						He.scrollTop =
							null != xe.pageYOffset
								? xe.pageYOffset
								: null != ce.documentElement.scrollTop
								? ce.documentElement.scrollTop
								: ce.body.scrollTop,
						He.scrollLeft =
							null != xe.pageXOffset
								? xe.pageXOffset
								: null != ce.documentElement.scrollLeft
								? ce.documentElement.scrollLeft
								: ce.body.scrollLeft,
						r = J.pointerX - He.scrollLeft,
						i = J.pointerY - He.scrollTop;
					c && !n;

				)
					(t = (n = Fe(c.parentNode)) ? He : c.parentNode),
						(o = n
							? {
									bottom: Math.max(ye.clientHeight, xe.innerHeight || 0),
									right: Math.max(ye.clientWidth, xe.innerWidth || 0),
									left: 0,
									top: 0,
							  }
							: t.getBoundingClientRect()),
						(a = l = 0),
						$ &&
							((s = t._gsMaxScrollY - t.scrollTop) < 0
								? (l = s)
								: i > o.bottom - oe && s
								? ((ee = !0),
								  (l = Math.min(
										s,
										(d * (1 - Math.max(0, o.bottom - i) / oe)) | 0
								  )))
								: i < o.top + te &&
								  t.scrollTop &&
								  ((ee = !0),
								  (l = -Math.min(
										t.scrollTop,
										(d * (1 - Math.max(0, i - o.top) / te)) | 0
								  ))),
							l && (t.scrollTop += l)),
						U &&
							((s = t._gsMaxScrollX - t.scrollLeft) < 0
								? (a = s)
								: r > o.right - ne && s
								? ((ee = !0),
								  (a = Math.min(
										s,
										(d * (1 - Math.max(0, o.right - r) / ne)) | 0
								  )))
								: r < o.left + re &&
								  t.scrollLeft &&
								  ((ee = !0),
								  (a = -Math.min(
										t.scrollLeft,
										(d * (1 - Math.max(0, r - o.left) / re)) | 0
								  ))),
							a && (t.scrollLeft += a)),
						n &&
							(a || l) &&
							(xe.scrollTo(t.scrollLeft, t.scrollTop),
							pe(J.pointerX + a, J.pointerY + l)),
						(c = t);
			}
			if (O) {
				var u = J.x,
					p = J.y;
				G
					? ((J.deltaX = u - parseFloat(le.rotation)),
					  (J.rotation = u),
					  (le.rotation = u + "deg"),
					  le.renderTransform(1, le))
					: f
					? ($ && ((J.deltaY = p - f.top()), f.top(p)),
					  U && ((J.deltaX = u - f.left()), f.left(u)))
					: W
					? ($ && ((J.deltaY = p - parseFloat(le.y)), (le.y = p + "px")),
					  U && ((J.deltaX = u - parseFloat(le.x)), (le.x = u + "px")),
					  le.renderTransform(1, le))
					: ($ &&
							((J.deltaY = p - parseFloat(h.style.top || 0)),
							(h.style.top = p + "px")),
					  U &&
							((J.deltaX = u - parseFloat(h.style.left || 0)),
							(h.style.left = u + "px"))),
					!g ||
						e ||
						H ||
						(!(H = !0) === Oa(J, "drag", "onDrag") &&
							(U && (J.x -= J.deltaX), $ && (J.y -= J.deltaY), vh(!0)),
						(H = !1));
			}
			O = !1;
		}
		function wh(e, t) {
			var n,
				o,
				r = J.x,
				i = J.y;
			h._gsap || (le = ge.core.getCache(h)),
				le.uncache && ge.getProperty(h, "x"),
				W
					? ((J.x = parseFloat(le.x)), (J.y = parseFloat(le.y)))
					: G
					? (J.x = J.rotation = parseFloat(le.rotation))
					: f
					? ((J.y = f.top()), (J.x = f.left()))
					: ((J.y = parseFloat(h.style.top || ((o = La(h)) && o.top)) || 0),
					  (J.x = parseFloat(h.style.left || (o || {}).left) || 0)),
				(P || k || _) &&
					!t &&
					(J.isDragging || J.isThrowing) &&
					(_ &&
						((Ie.x = J.x),
						(Ie.y = J.y),
						(n = _(Ie)).x !== J.x && ((J.x = n.x), (O = !0)),
						n.y !== J.y && ((J.y = n.y), (O = !0))),
					P &&
						(n = P(J.x)) !== J.x &&
						((J.x = n), G && (J.rotation = n), (O = !0)),
					k && ((n = k(J.y)) !== J.y && (J.y = n), (O = !0))),
				O && vh(!0),
				e ||
					((J.deltaX = J.x - r),
					(J.deltaY = J.y - i),
					Oa(J, "throwupdate", "onThrowUpdate"));
		}
		function xh(a, l, s, n) {
			return (
				null == l && (l = -Pe),
				null == s && (s = Pe),
				X(a)
					? function (e) {
							var t = J.isPressed ? 1 - J.edgeResistance : 1;
							return (
								a.call(
									J,
									s < e ? s + (e - s) * t : e < l ? l + (e - l) * t : e
								) * n
							);
					  }
					: Ne(a)
					? function (e) {
							for (var t, n, o = a.length, r = 0, i = Pe; -1 < --o; )
								(n = (t = a[o]) - e) < 0 && (n = -n),
									n < i && l <= t && t <= s && ((r = o), (i = n));
							return a[r];
					  }
					: isNaN(a)
					? function (e) {
							return e;
					  }
					: function () {
							return a * n;
					  }
			);
		}
		function zh() {
			var e, t, n, o;
			(E = !1),
				f
					? (f.calibrate(),
					  (J.minX = L = -f.maxScrollLeft()),
					  (J.minY = C = -f.maxScrollTop()),
					  (J.maxX = M = J.maxY = S = 0),
					  (E = !0))
					: u.bounds &&
					  ((e = Pa(u.bounds, h.parentNode)),
					  G
							? ((J.minX = L = e.left),
							  (J.maxX = M = e.left + e.width),
							  (J.minY = C = J.maxY = S = 0))
							: Z(u.bounds.maxX) && Z(u.bounds.maxY)
							? ((t = Pa(h, h.parentNode)),
							  (J.minX = L = Math.round(Og(K, "px") + e.left - t.left)),
							  (J.minY = C = Math.round(Og(V, "px") + e.top - t.top)),
							  (J.maxX = M = Math.round(L + (e.width - t.width))),
							  (J.maxY = S = Math.round(C + (e.height - t.height))))
							: ((e = u.bounds),
							  (J.minX = L = e.minX),
							  (J.minY = C = e.minY),
							  (J.maxX = M = e.maxX),
							  (J.maxY = S = e.maxY)),
					  M < L && ((J.minX = M), (J.maxX = M = L), (L = J.minX)),
					  S < C && ((J.minY = S), (J.maxY = S = C), (C = J.minY)),
					  G && ((J.minRotation = L), (J.maxRotation = M)),
					  (E = !0)),
				u.liveSnap &&
					((n = !0 === u.liveSnap ? u.snap || {} : u.liveSnap),
					(o = Ne(n) || X(n)),
					G
						? ((P = xh(o ? n : n.rotation, L, M, 1)), (k = null))
						: n.points
						? (_ = (function buildPointSnapFunc(s, l, c, d, u, p, h) {
								return (
									(p = p && p < Pe ? p * p : Pe),
									X(s)
										? function (e) {
												var t,
													n,
													o,
													r = J.isPressed ? 1 - J.edgeResistance : 1,
													i = e.x,
													a = e.y;
												return (
													(e.x = i =
														c < i
															? c + (i - c) * r
															: i < l
															? l + (i - l) * r
															: i),
													(e.y = a =
														u < a
															? u + (a - u) * r
															: a < d
															? d + (a - d) * r
															: a),
													(t = s.call(J, e)) !== e &&
														((e.x = t.x), (e.y = t.y)),
													1 !== h && ((e.x *= h), (e.y *= h)),
													p < Pe &&
														((n = e.x - i),
														(o = e.y - a),
														p < n * n + o * o && ((e.x = i), (e.y = a))),
													e
												);
										  }
										: Ne(s)
										? function (e) {
												for (
													var t, n, o, r, i = s.length, a = 0, l = Pe;
													-1 < --i;

												)
													(r =
														(t = (o = s[i]).x - e.x) * t +
														(n = o.y - e.y) * n) < l && ((a = i), (l = r));
												return l <= p ? s[a] : e;
										  }
										: function (e) {
												return e;
										  }
								);
						  })(o ? n : n.points, L, M, C, S, n.radius, f ? -1 : 1))
						: (U &&
								(P = xh(
									o ? n : n.x || n.left || n.scrollLeft,
									L,
									M,
									f ? -1 : 1
								)),
						  $ &&
								(k = xh(
									o ? n : n.y || n.top || n.scrollTop,
									C,
									S,
									f ? -1 : 1
								))));
		}
		function Ah() {
			(J.isThrowing = !1), Oa(J, "throwcomplete", "onThrowComplete");
		}
		function Bh() {
			J.isThrowing = !1;
		}
		function Ch(e, t) {
			var n, o, r, i;
			e && Le
				? (!0 === e &&
						((n = u.snap || u.liveSnap || {}),
						(o = Ne(n) || X(n)),
						(e = {
							resistance:
								(u.throwResistance || u.resistance || 1e3) / (G ? 10 : 1),
						}),
						G
							? (e.rotation = Sa(J, o ? n : n.rotation, M, L, 1, t))
							: (U &&
									(e[K] = Sa(
										J,
										o ? n : n.points || n.x || n.left,
										M,
										L,
										f ? -1 : 1,
										t || "x" === J.lockedAxis
									)),
							  $ &&
									(e[V] = Sa(
										J,
										o ? n : n.points || n.y || n.top,
										S,
										C,
										f ? -1 : 1,
										t || "y" === J.lockedAxis
									)),
							  (n.points || (Ne(n) && Y(n[0]))) &&
									((e.linkedProps = K + "," + V), (e.radius = n.radius)))),
				  (J.isThrowing = !0),
				  (i = isNaN(u.overshootTolerance)
						? 1 === u.edgeResistance
							? 0
							: 1 - J.edgeResistance + 0.2
						: u.overshootTolerance),
				  e.duration ||
						(e.duration = {
							max: Math.max(
								u.minDuration || 0,
								"maxDuration" in u ? u.maxDuration : 2
							),
							min: isNaN(u.minDuration)
								? 0 === i || (Y(e) && 1e3 < e.resistance)
									? 0
									: 0.5
								: u.minDuration,
							overshoot: i,
						}),
				  (J.tween = r =
						ge.to(f || h, {
							inertia: e,
							data: "_draggable",
							onComplete: Ah,
							onInterrupt: Bh,
							onUpdate: u.fastMode ? Oa : wh,
							onUpdateParams: u.fastMode
								? [J, "onthrowupdate", "onThrowUpdate"]
								: n && n.radius
								? [!1, !0]
								: [],
						})),
				  u.fastMode ||
						(f && (f._skip = !0),
						r.render(1e9, !0, !0),
						wh(!0, !0),
						(J.endX = J.x),
						(J.endY = J.y),
						G && (J.endRotation = J.x),
						r.play(0),
						wh(!0, !0),
						f && (f._skip = !1)))
				: E && J.applyBounds();
		}
		function Dh(e) {
			var t,
				n = R;
			(R = getGlobalMatrix(h.parentNode, !0)),
				e &&
					J.isPressed &&
					!R.equals(n || new fe()) &&
					((t = n.inverse().apply({ x: w, y: b })),
					R.apply(t, t),
					(w = t.x),
					(b = t.y)),
				R.equals(a) && (R = null);
		}
		function Eh() {
			var e,
				t,
				n,
				o = 1 - J.edgeResistance,
				r = se ? Ea(ce) : 0,
				i = se ? Da(ce) : 0;
			Dh(!1),
				(ze.x = J.pointerX - r),
				(ze.y = J.pointerY - i),
				R && R.apply(ze, ze),
				(w = ze.x),
				(b = ze.y),
				O && (pe(J.pointerX, J.pointerY), vh(!0)),
				(d = getGlobalMatrix(h)),
				f
					? (zh(), (D = f.top()), (T = f.left()))
					: (de() ? (wh(!0, !0), zh()) : J.applyBounds(),
					  G
							? ((e = h.ownerSVGElement
									? [le.xOrigin - h.getBBox().x, le.yOrigin - h.getBBox().y]
									: (La(h)[Ce] || "0 0").split(" ")),
							  (N = J.rotationOrigin =
									getGlobalMatrix(h).apply({
										x: parseFloat(e[0]) || 0,
										y: parseFloat(e[1]) || 0,
									})),
							  wh(!0, !0),
							  (t = J.pointerX - N.x - r),
							  (n = N.y - J.pointerY + i),
							  (T = J.x),
							  (D = J.y = Math.atan2(n, t) * Oe))
							: ((D = Og(V, "px")), (T = Og(K, "px")))),
				E &&
					o &&
					(M < T ? (T = M + (T - M) / o) : T < L && (T = L - (L - T) / o),
					G ||
						(S < D ? (D = S + (D - S) / o) : D < C && (D = C - (C - D) / o))),
				(J.startX = T = ba(T)),
				(J.startY = D = ba(D));
		}
		function Gh() {
			!ve.parentNode || de() || J.isDragging || ve.parentNode.removeChild(ve);
		}
		function Hh(e, t) {
			var n;
			if (
				!p ||
				J.isPressed ||
				!e ||
				(!(("mousedown" !== e.type && "pointerdown" !== e.type) || t) &&
					ke() - ae < 30 &&
					De[J.pointerEvent.type])
			)
				z && e && p && za(e);
			else {
				if (
					((A = de()),
					(J.pointerEvent = e),
					De[e.type]
						? ((v = ~e.type.indexOf("touch")
								? e.currentTarget || e.target
								: ce),
						  xa(v, "touchend", he),
						  xa(v, "touchmove", ue),
						  xa(v, "touchcancel", he),
						  xa(ce, "touchstart", Ca))
						: ((v = null), xa(ce, "mousemove", ue)),
					(I = null),
					(Ye && v) ||
						(xa(ce, "mouseup", he),
						e && e.target && xa(e.target, "mouseup", he)),
					(y = ie.call(J, e.target) && !1 === u.dragClickables && !t))
				)
					return (
						xa(e.target, "change", he),
						Oa(J, "pressInit", "onPressInit"),
						Oa(J, "press", "onPress"),
						Ua(q, !0),
						void (z = !1)
					);
				if (
					((B =
						!(
							!v ||
							U == $ ||
							!1 === J.vars.allowNativeTouchScrolling ||
							(J.vars.allowContextMenu && e && (e.ctrlKey || 2 < e.which))
						) && (U ? "y" : "x")),
					(z = !B && !J.allowEventDefault) &&
						(za(e), xa(xe, "touchforcechange", za)),
					e.changedTouches
						? ((e = x = e.changedTouches[0]), (m = e.identifier))
						: e.pointerId
						? (m = e.pointerId)
						: (x = m = null),
					Ee++,
					(function _addToRenderQueue(e) {
						_e.push(e), 1 === _e.length && ge.ticker.add(sa);
					})(vh),
					(b = J.pointerY = e.pageY),
					(w = J.pointerX = e.pageX),
					Oa(J, "pressInit", "onPressInit"),
					(B || J.autoScroll) && Ja(h.parentNode),
					!h.parentNode ||
						!J.autoScroll ||
						f ||
						G ||
						!h.parentNode._gsMaxScrollX ||
						ve.parentNode ||
						h.getBBox ||
						((ve.style.width = h.parentNode.scrollWidth + "px"),
						h.parentNode.appendChild(ve)),
					Eh(),
					J.tween && J.tween.kill(),
					(J.isThrowing = !1),
					ge.killTweensOf(f || h, o, !0),
					f && ge.killTweensOf(h, { scrollTo: 1 }, !0),
					(J.tween = J.lockedAxis = null),
					(!u.zIndexBoost && (G || f || !1 === u.zIndexBoost)) ||
						(h.style.zIndex = Draggable.zIndex++),
					(J.isPressed = !0),
					(g = !(!u.onDrag && !J._listeners.drag)),
					(s = !(!u.onMove && !J._listeners.move)),
					!1 !== u.cursor || u.activeCursor)
				)
					for (n = q.length; -1 < --n; )
						ge.set(q[n], {
							cursor:
								u.activeCursor || u.cursor || ("grab" === Se ? "grabbing" : Se),
						});
				Oa(J, "press", "onPress");
			}
		}
		function Lh(e) {
			if (e && J.isDragging && !f) {
				var t = e.target || h.parentNode,
					n = t.scrollLeft - t._gsScrollX,
					o = t.scrollTop - t._gsScrollY;
				(n || o) &&
					(R
						? ((w -= n * R.a + o * R.c), (b -= o * R.d + n * R.b))
						: ((w -= n), (b -= o)),
					(t._gsScrollX += n),
					(t._gsScrollY += o),
					pe(J.pointerX, J.pointerY));
			}
		}
		function Mh(e) {
			var t = ke(),
				n = t - ae < 100,
				o = t - Q < 50,
				r = n && F === ae,
				i = J.pointerEvent && J.pointerEvent.defaultPrevented,
				a = n && c === ae,
				l = e.isTrusted || (null == e.isTrusted && n && r);
			if (
				((r || (o && !1 !== J.vars.suppressClickOnDrag)) &&
					e.stopImmediatePropagation &&
					e.stopImmediatePropagation(),
				n &&
					(!J.pointerEvent || !J.pointerEvent.defaultPrevented) &&
					(!r || (l && !a)))
			)
				return l && r && (c = ae), void (F = ae);
			(J.isPressed || o || n) && ((l && e.detail && n && !i) || za(e)),
				n ||
					o ||
					(e && e.target && (J.pointerEvent = e), Oa(J, "click", "onClick"));
		}
		function Nh(e) {
			return R
				? { x: e.x * R.a + e.y * R.c + R.e, y: e.x * R.b + e.y * R.d + R.f }
				: { x: e.x, y: e.y };
		}
		var p,
			f,
			w,
			b,
			T,
			D,
			E,
			g,
			s,
			M,
			L,
			S,
			C,
			x,
			m,
			N,
			O,
			t,
			P,
			k,
			_,
			y,
			v,
			R,
			A,
			B,
			I,
			H,
			F,
			c,
			z,
			d,
			n = (u.type || "x,y").toLowerCase(),
			W = ~n.indexOf("x") || ~n.indexOf("y"),
			G = -1 !== n.indexOf("rotation"),
			K = G ? "rotation" : W ? "x" : "left",
			V = W ? "y" : "top",
			U = !(!~n.indexOf("x") && !~n.indexOf("left") && "scroll" !== n),
			$ = !(!~n.indexOf("y") && !~n.indexOf("top") && "scroll" !== n),
			j = u.minimumMovement || 2,
			J = (function _assertThisInitialized(e) {
				if (void 0 === e)
					throw new ReferenceError(
						"this hasn't been initialised - super() hasn't been called"
					);
				return e;
			})(e),
			q = be(u.trigger || u.handle || h),
			o = {},
			Q = 0,
			ee = !1,
			te = u.autoScrollMarginTop || 40,
			ne = u.autoScrollMarginRight || 40,
			oe = u.autoScrollMarginBottom || 40,
			re = u.autoScrollMarginLeft || 40,
			ie = u.clickableTest || Ta,
			ae = 0,
			le = h._gsap || ge.core.getCache(h),
			se = (function _isFixed(e) {
				return (
					"fixed" === La(e).position ||
					((e = e.parentNode) && 1 === e.nodeType ? _isFixed(e) : void 0)
				);
			})(h),
			ce = h.ownerDocument || me,
			de = function isTweening() {
				return J.tween && J.tween.isActive();
			},
			ue = function onMove(e) {
				var t,
					n,
					o,
					r,
					i,
					a,
					l = e;
				if (p && !Me && J.isPressed && e) {
					if ((t = (J.pointerEvent = e).changedTouches)) {
						if ((e = t[0]) !== x && e.identifier !== m) {
							for (
								r = t.length;
								-1 < --r && (e = t[r]).identifier !== m && e.target !== h;

							);
							if (r < 0) return;
						}
					} else if (e.pointerId && m && e.pointerId !== m) return;
					v &&
					B &&
					!I &&
					((ze.x = e.pageX - (se ? Ea(ce) : 0)),
					(ze.y = e.pageY - (se ? Da(ce) : 0)),
					R && R.apply(ze, ze),
					(n = ze.x),
					(o = ze.y),
					(((i = Math.abs(n - w)) !== (a = Math.abs(o - b)) &&
						(j < i || j < a)) ||
						(Xe && B === I)) &&
						((I = a < i && U ? "x" : "y"),
						B && I !== B && xa(xe, "touchforcechange", za),
						!1 !== J.vars.lockAxisOnTouchScroll &&
							U &&
							$ &&
							((J.lockedAxis = "x" === I ? "y" : "x"),
							X(J.vars.onLockAxis) && J.vars.onLockAxis.call(J, l)),
						Xe && B === I))
						? he(l)
						: ((z =
								J.allowEventDefault ||
								(B && (!I || B === I)) ||
								!1 === l.cancelable
									? z && !1
									: (za(l), !0)),
						  J.autoScroll && (ee = !0),
						  pe(e.pageX, e.pageY, s));
				} else z && e && p && za(e);
			},
			pe = function setPointerPosition(e, t, n) {
				var o,
					r,
					i,
					a,
					l,
					s,
					c = 1 - J.dragResistance,
					d = 1 - J.edgeResistance,
					u = J.pointerX,
					p = J.pointerY,
					h = D,
					f = J.x,
					g = J.y,
					x = J.endX,
					m = J.endY,
					y = J.endRotation,
					v = O;
				(J.pointerX = e),
					(J.pointerY = t),
					se && ((e -= Ea(ce)), (t -= Da(ce))),
					G
						? ((a = Math.atan2(N.y - t, e - N.x) * Oe),
						  180 < (l = J.y - a)
								? ((D -= 360), (J.y = a))
								: l < -180 && ((D += 360), (J.y = a)),
						  (i =
								J.x !== T || Math.abs(D - a) > j
									? ((J.y = a), T + (D - a) * c)
									: T))
						: (R &&
								((s = e * R.a + t * R.c + R.e),
								(t = e * R.b + t * R.d + R.f),
								(e = s)),
						  (r = t - b) < j && -j < r && (r = 0),
						  (o = e - w) < j && -j < o && (o = 0),
						  (J.lockAxis || J.lockedAxis) &&
								(o || r) &&
								((s = J.lockedAxis) ||
									((J.lockedAxis = s =
										U && Math.abs(o) > Math.abs(r) ? "y" : $ ? "x" : null),
									s &&
										X(J.vars.onLockAxis) &&
										J.vars.onLockAxis.call(J, J.pointerEvent)),
								"y" === s ? (r = 0) : "x" === s && (o = 0)),
						  (i = ba(T + o * c)),
						  (a = ba(D + r * c))),
					(P || k || _) &&
						(J.x !== i || (J.y !== a && !G)) &&
						(_ &&
							((Ie.x = i),
							(Ie.y = a),
							(s = _(Ie)),
							(i = ba(s.x)),
							(a = ba(s.y))),
						P && (i = ba(P(i))),
						k && (a = ba(k(a)))),
					E &&
						(M < i
							? (i = M + Math.round((i - M) * d))
							: i < L && (i = L + Math.round((i - L) * d)),
						G ||
							(S < a
								? (a = Math.round(S + (a - S) * d))
								: a < C && (a = Math.round(C + (a - C) * d)))),
					(J.x === i && (J.y === a || G)) ||
						(G
							? ((J.endRotation = J.x = J.endX = i), (O = !0))
							: ($ && ((J.y = J.endY = a), (O = !0)),
							  U && ((J.x = J.endX = i), (O = !0))),
						n && !1 === Oa(J, "move", "onMove")
							? ((J.pointerX = u),
							  (J.pointerY = p),
							  (D = h),
							  (J.x = f),
							  (J.y = g),
							  (J.endX = x),
							  (J.endY = m),
							  (J.endRotation = y),
							  (O = v))
							: !J.isDragging &&
							  J.isPressed &&
							  ((J.isDragging = !0), Oa(J, "dragstart", "onDragStart")));
			},
			he = function onRelease(e, t) {
				if (
					p &&
					J.isPressed &&
					(!e ||
						null == m ||
						t ||
						!(
							(e.pointerId && e.pointerId !== m && e.target !== h) ||
							(e.changedTouches &&
								!(function _hasTouchID(e, t) {
									for (var n = e.length; n--; )
										if (e[n].identifier === t) return !0;
								})(e.changedTouches, m))
						))
				) {
					J.isPressed = !1;
					var n,
						o,
						r,
						i,
						a,
						l = e,
						s = J.isDragging,
						c = J.vars.allowContextMenu && e && (e.ctrlKey || 2 < e.which),
						d = ge.delayedCall(0.001, Gh);
					if (
						(v
							? (ya(v, "touchend", onRelease),
							  ya(v, "touchmove", ue),
							  ya(v, "touchcancel", onRelease),
							  ya(ce, "touchstart", Ca))
							: ya(ce, "mousemove", ue),
						ya(xe, "touchforcechange", za),
						(Ye && v) ||
							(ya(ce, "mouseup", onRelease),
							e && e.target && ya(e.target, "mouseup", onRelease)),
						(O = !1),
						s && ((Q = Be = ke()), (J.isDragging = !1)),
						y && !c)
					)
						return (
							e && (ya(e.target, "change", onRelease), (J.pointerEvent = l)),
							Ua(q, !1),
							Oa(J, "release", "onRelease"),
							Oa(J, "click", "onClick"),
							void (y = !1)
						);
					for (va(vh), o = q.length; -1 < --o; )
						Ka(q[o], "cursor", u.cursor || (!1 !== u.cursor ? Se : null));
					if ((Ee--, e)) {
						if (
							(n = e.changedTouches) &&
							(e = n[0]) !== x &&
							e.identifier !== m
						) {
							for (
								o = n.length;
								-1 < --o && (e = n[o]).identifier !== m && e.target !== h;

							);
							if (o < 0) return;
						}
						(J.pointerEvent = l),
							(J.pointerX = e.pageX),
							(J.pointerY = e.pageY);
					}
					return (
						c && l
							? (za(l), (z = !0), Oa(J, "release", "onRelease"))
							: l && !s
							? ((z = !1),
							  A && (u.snap || u.bounds) && Ch(u.inertia || u.throwProps),
							  Oa(J, "release", "onRelease"),
							  (Xe && "touchmove" === l.type) ||
									-1 !== l.type.indexOf("cancel") ||
									(Oa(J, "click", "onClick"),
									ke() - ae < 300 && Oa(J, "doubleclick", "onDoubleClick"),
									(i = l.target || h),
									(ae = ke()),
									(a = function syntheticClick() {
										ae === F ||
											!J.enabled() ||
											J.isPressed ||
											l.defaultPrevented ||
											(i.click
												? i.click()
												: ce.createEvent &&
												  ((r = ce.createEvent("MouseEvents")).initMouseEvent(
														"click",
														!0,
														!0,
														xe,
														1,
														J.pointerEvent.screenX,
														J.pointerEvent.screenY,
														J.pointerX,
														J.pointerY,
														!1,
														!1,
														!1,
														!1,
														0,
														null
												  ),
												  i.dispatchEvent(r)));
									}),
									Xe || l.defaultPrevented || ge.delayedCall(0.05, a)))
							: (Ch(u.inertia || u.throwProps),
							  J.allowEventDefault ||
							  !l ||
							  (!1 === u.dragClickables && ie.call(J, l.target)) ||
							  !s ||
							  (B && (!I || B !== I)) ||
							  !1 === l.cancelable
									? (z = !1)
									: ((z = !0), za(l)),
							  Oa(J, "release", "onRelease")),
						de() && d.duration(J.tween.duration()),
						s && Oa(J, "dragend", "onDragEnd"),
						!0
					);
				}
				z && e && p && za(e);
			};
		return (
			(t = Draggable.get(h)) && t.kill(),
			(e.startDrag = function (e, t) {
				var n, o, r, i;
				Hh(e || J.pointerEvent, !0),
					t &&
						!J.hitTest(e || J.pointerEvent) &&
						((n = Na(e || J.pointerEvent)),
						(o = Na(h)),
						(r = Nh({ x: n.left + n.width / 2, y: n.top + n.height / 2 })),
						(i = Nh({ x: o.left + o.width / 2, y: o.top + o.height / 2 })),
						(w -= r.x - i.x),
						(b -= r.y - i.y)),
					J.isDragging ||
						((J.isDragging = !0), Oa(J, "dragstart", "onDragStart"));
			}),
			(e.drag = ue),
			(e.endDrag = function (e) {
				return he(e || J.pointerEvent, !0);
			}),
			(e.timeSinceDrag = function () {
				return J.isDragging ? 0 : (ke() - Q) / 1e3;
			}),
			(e.timeSinceClick = function () {
				return (ke() - ae) / 1e3;
			}),
			(e.hitTest = function (e, t) {
				return Draggable.hitTest(J.target, e, t);
			}),
			(e.getDirection = function (e, t) {
				var n,
					o,
					r,
					i,
					a,
					l,
					s = "velocity" === e && Le ? e : Y(e) && !G ? "element" : "start";
				return (
					"element" === s && ((a = Na(J.target)), (l = Na(e))),
					(n =
						"start" === s
							? J.x - T
							: "velocity" === s
							? Le.getVelocity(h, K)
							: a.left + a.width / 2 - (l.left + l.width / 2)),
					G
						? n < 0
							? "counter-clockwise"
							: "clockwise"
						: ((t = t || 2),
						  (o =
								"start" === s
									? J.y - D
									: "velocity" === s
									? Le.getVelocity(h, V)
									: a.top + a.height / 2 - (l.top + l.height / 2)),
						  (i =
								(r = Math.abs(n / o)) < 1 / t ? "" : n < 0 ? "left" : "right"),
						  r < t && ("" !== i && (i += "-"), (i += o < 0 ? "up" : "down")),
						  i)
				);
			}),
			(e.applyBounds = function (e, t) {
				var n, o, r, i, a, l;
				if (e && u.bounds !== e) return (u.bounds = e), J.update(!0, t);
				if ((wh(!0), zh(), E && !de())) {
					if (
						((n = J.x),
						(o = J.y),
						M < n ? (n = M) : n < L && (n = L),
						S < o ? (o = S) : o < C && (o = C),
						(J.x !== n || J.y !== o) &&
							((r = !0),
							(J.x = J.endX = n),
							G ? (J.endRotation = n) : (J.y = J.endY = o),
							vh((O = !0)),
							J.autoScroll && !J.isDragging))
					)
						for (
							Ja(h.parentNode),
								i = h,
								He.scrollTop =
									null != xe.pageYOffset
										? xe.pageYOffset
										: null != ce.documentElement.scrollTop
										? ce.documentElement.scrollTop
										: ce.body.scrollTop,
								He.scrollLeft =
									null != xe.pageXOffset
										? xe.pageXOffset
										: null != ce.documentElement.scrollLeft
										? ce.documentElement.scrollLeft
										: ce.body.scrollLeft;
							i && !l;

						)
							(a = (l = Fe(i.parentNode)) ? He : i.parentNode),
								$ &&
									a.scrollTop > a._gsMaxScrollY &&
									(a.scrollTop = a._gsMaxScrollY),
								U &&
									a.scrollLeft > a._gsMaxScrollX &&
									(a.scrollLeft = a._gsMaxScrollX),
								(i = a);
					J.isThrowing &&
						(r || J.endX > M || J.endX < L || J.endY > S || J.endY < C) &&
						Ch(u.inertia || u.throwProps, r);
				}
				return J;
			}),
			(e.update = function (e, t, n) {
				if (t && J.isPressed) {
					var o = getGlobalMatrix(h),
						r = d.apply({ x: J.x - T, y: J.y - D }),
						i = getGlobalMatrix(h.parentNode, !0);
					i.apply({ x: o.e - r.x, y: o.f - r.y }, r),
						(J.x -= r.x - i.e),
						(J.y -= r.y - i.f),
						vh(!0),
						Eh();
				}
				var a = J.x,
					l = J.y;
				return (
					Dh(!t),
					e ? J.applyBounds() : (O && n && vh(!0), wh(!0)),
					t && (pe(J.pointerX, J.pointerY), O && vh(!0)),
					J.isPressed &&
						!t &&
						((U && 0.01 < Math.abs(a - J.x)) ||
							($ && 0.01 < Math.abs(l - J.y) && !G)) &&
						Eh(),
					J.autoScroll &&
						(Ja(h.parentNode, J.isDragging),
						(ee = J.isDragging),
						vh(!0),
						Ga(h, Lh),
						Fa(h, Lh)),
					J
				);
			}),
			(e.enable = function (e) {
				var t,
					n,
					o,
					r = { lazy: !0 };
				if (
					(!1 !== u.cursor && (r.cursor = u.cursor || Se),
					ge.utils.checkPrefix("touchCallout") && (r.touchCallout = "none"),
					"soft" !== e)
				) {
					for (
						ra(
							q,
							U == $
								? "none"
								: (u.allowNativeTouchScrolling &&
										(h.scrollHeight === h.clientHeight) ==
											(h.scrollWidth === h.clientHeight)) ||
								  u.allowEventDefault
								? "manipulation"
								: U
								? "pan-y"
								: "pan-x"
						),
							n = q.length;
						-1 < --n;

					)
						(o = q[n]),
							Ye || xa(o, "mousedown", Hh),
							xa(o, "touchstart", Hh),
							xa(o, "click", Mh, !0),
							ge.set(o, r),
							o.getBBox &&
								o.ownerSVGElement &&
								ge.set(o.ownerSVGElement, {
									touchAction:
										U == $
											? "none"
											: u.allowNativeTouchScrolling || u.allowEventDefault
											? "manipulation"
											: U
											? "pan-y"
											: "pan-x",
								}),
							u.allowContextMenu || xa(o, "contextmenu", uh);
					Ua(q, !1);
				}
				return (
					Fa(h, Lh),
					(p = !0),
					Le &&
						"soft" !== e &&
						Le.track(f || h, W ? "x,y" : G ? "rotation" : "top,left"),
					(h._gsDragID = t = "d" + Ae++),
					(Re[t] = J),
					f && (f.enable(), (f.element._gsDragID = t)),
					(u.bounds || G) && Eh(),
					u.bounds && J.applyBounds(),
					J
				);
			}),
			(e.disable = function (e) {
				for (var t, n = J.isDragging, o = q.length; -1 < --o; )
					Ka(q[o], "cursor", null);
				if ("soft" !== e) {
					for (ra(q, null), o = q.length; -1 < --o; )
						(t = q[o]),
							Ka(t, "touchCallout", null),
							ya(t, "mousedown", Hh),
							ya(t, "touchstart", Hh),
							ya(t, "click", Mh),
							ya(t, "contextmenu", uh);
					Ua(q, !0),
						v &&
							(ya(v, "touchcancel", he),
							ya(v, "touchend", he),
							ya(v, "touchmove", ue)),
						ya(ce, "mouseup", he),
						ya(ce, "mousemove", ue);
				}
				return (
					Ga(h, Lh),
					(p = !1),
					Le &&
						"soft" !== e &&
						Le.untrack(f || h, W ? "x,y" : G ? "rotation" : "top,left"),
					f && f.disable(),
					va(vh),
					(J.isDragging = J.isPressed = y = !1),
					n && Oa(J, "dragend", "onDragEnd"),
					J
				);
			}),
			(e.enabled = function (e, t) {
				return arguments.length ? (e ? J.enable(t) : J.disable(t)) : p;
			}),
			(e.kill = function () {
				return (
					(J.isThrowing = !1),
					J.tween && J.tween.kill(),
					J.disable(),
					ge.set(q, { clearProps: "userSelect" }),
					delete Re[h._gsDragID],
					J
				);
			}),
			~n.indexOf("scroll") &&
				((f = e.scrollProxy =
					new Ya(
						h,
						(function _extend(e, t) {
							for (var n in t) n in e || (e[n] = t[n]);
							return e;
						})(
							{
								onKill: function onKill() {
									J.isPressed && he(null);
								},
							},
							u
						)
					)),
				(h.style.overflowY = $ && !Te ? "auto" : "hidden"),
				(h.style.overflowX = U && !Te ? "auto" : "hidden"),
				(h = f.content)),
			G ? (o.rotation = 1) : (U && (o[K] = 1), $ && (o[V] = 1)),
			(le.force3D = !("force3D" in u) || u.force3D),
			e.enable(),
			e
		);
	}
	!(function _setDefaults(e, t) {
		for (var n in t) n in e || (e[n] = t[n]);
	})(I.prototype, {
		pointerX: 0,
		pointerY: 0,
		startX: 0,
		startY: 0,
		deltaX: 0,
		deltaY: 0,
		isDragging: !1,
		isPressed: !1,
	}),
		(I.zIndex = 1e3),
		(I.version = "3.9.1"),
		W() && ge.registerPlugin(I),
		(e.Draggable = I),
		(e.default = I);
	if (typeof window === "undefined" || window !== e) {
		Object.defineProperty(e, "__esModule", { value: !0 });
	} else {
		delete e.default;
	}
});

!(function (t, e) {
	"object" == typeof exports && "undefined" != typeof module
		? e(exports)
		: "function" == typeof define && define.amd
		? define(["exports"], e)
		: e(((t = t || self).window = t.window || {}));
})(this, function (e) {
	"use strict";
	function m() {
		return i || ("undefined" != typeof window && (i = window.gsap));
	}
	function p(t) {
		return c(t).id;
	}
	function q(t) {
		return f[p("string" == typeof t ? g(t)[0] : t)];
	}
	function r(t) {
		var e,
			r = o;
		if (0.05 <= t - s)
			for (s = t; r; )
				((e = r.g(r.t, r.p)) !== r.v1 || 0.2 < t - r.t1) &&
					((r.v2 = r.v1), (r.v1 = e), (r.t2 = r.t1), (r.t1 = t)),
					(r = r._next);
	}
	function t() {
		(i = m()) &&
			((g = i.utils.toArray),
			(n = i.utils.getUnit),
			(c = i.core.getCache),
			(a = i.ticker),
			(l = 1));
	}
	function u(t, e, r, i) {
		(this.t = t),
			(this.p = e),
			(this.g = t._gsap.get),
			(this.rCap = d[r || n(this.g(t, e))]),
			(this.v1 = this.v2 = 0),
			(this.t1 = this.t2 = a.time),
			i && ((this._next = i)._prev = this);
	}
	var i,
		l,
		g,
		n,
		o,
		a,
		s,
		c,
		f = {},
		d = { deg: 360, rad: 2 * Math.PI },
		v = (function () {
			function VelocityTracker(e, r) {
				l || t(),
					(this.target = g(e)[0]),
					((f[p(this.target)] = this)._props = {}),
					r && this.add(r);
			}
			VelocityTracker.register = function register(e) {
				(i = e), t();
			};
			var e = VelocityTracker.prototype;
			return (
				(e.get = function get(t, e) {
					var r,
						i,
						n =
							this._props[t] ||
							console.warn("Not tracking " + t + " velocity.");
					return (
						(r = parseFloat(e ? n.v1 : n.g(n.t, n.p)) - parseFloat(n.v2)),
						(i = n.rCap) &&
							(r %= i) !== r % (i / 2) &&
							(r = r < 0 ? r + i : r - i),
						(function _round(t) {
							return Math.round(1e4 * t) / 1e4;
						})(r / ((e ? n.t1 : a.time) - n.t2))
					);
				}),
				(e.getAll = function getAll() {
					var t,
						e = {},
						r = this._props;
					for (t in r) e[t] = this.get(t);
					return e;
				}),
				(e.isTracking = function isTracking(t) {
					return t in this._props;
				}),
				(e.add = function add(t, e) {
					t in this._props ||
						(o || (a.add(r), (s = a.time)),
						(o = this._props[t] = new u(this.target, t, e, o)));
				}),
				(e.remove = function remove(t) {
					var e,
						i,
						n = this._props[t];
					n &&
						((e = n._prev),
						(i = n._next),
						e && (e._next = i),
						i ? (i._prev = e) : o === n && (a.remove(r), (o = 0)),
						delete this._props[t]);
				}),
				(e.kill = function kill(t) {
					for (var e in this._props) this.remove(e);
					t || delete f[p(this.target)];
				}),
				(VelocityTracker.track = function track(e, r, i) {
					l || t();
					for (
						var n,
							o,
							a = [],
							s = g(e),
							c = r.split(","),
							u = (i || "").split(","),
							f = s.length;
						f--;

					) {
						for (n = q(s[f]) || new VelocityTracker(s[f]), o = c.length; o--; )
							n.add(c[o], u[o] || u[0]);
						a.push(n);
					}
					return a;
				}),
				(VelocityTracker.untrack = function untrack(t, e) {
					var r = (e || "").split(",");
					g(t).forEach(function (t) {
						var e = q(t);
						e &&
							(r.length
								? r.forEach(function (t) {
										return e.remove(t);
								  })
								: e.kill(1));
					});
				}),
				(VelocityTracker.isTracking = function isTracking(t, e) {
					var r = q(t);
					return r && r.isTracking(e);
				}),
				(VelocityTracker.getVelocity = function getVelocity(t, e) {
					var r = q(t);
					return r && r.isTracking(e)
						? r.get(e)
						: console.warn("Not tracking velocity of " + e);
				}),
				VelocityTracker
			);
		})();
	(v.getByTarget = q), m() && i.registerPlugin(v);
	function J() {
		return (
			h ||
			("undefined" != typeof window &&
				(h = window.gsap) &&
				h.registerPlugin &&
				h)
		);
	}
	function L(t) {
		return "number" == typeof t;
	}
	function M(t) {
		return "object" == typeof t;
	}
	function N(t) {
		return "function" == typeof t;
	}
	function Q(t) {
		return t;
	}
	function U(t) {
		return Math.round(1e4 * t) / 1e4;
	}
	function V(t, e, r) {
		for (var i in e) i in t || i === r || (t[i] = e[i]);
		return t;
	}
	function W(t) {
		var e,
			r,
			i = {};
		for (e in t) i[e] = M((r = t[e])) && !w(r) ? W(r) : r;
		return i;
	}
	function X(t, e, r, i, n) {
		var o,
			a,
			s,
			c,
			u = e.length,
			f = 0,
			l = B;
		if (M(t)) {
			for (; u--; ) {
				for (s in ((o = e[u]), (a = 0), t)) a += (c = o[s] - t[s]) * c;
				a < l && ((f = u), (l = a));
			}
			if ((n || B) < B && n < Math.sqrt(l)) return t;
		} else for (; u--; ) (a = (o = e[u]) - t) < 0 && (a = -a), a < l && i <= o && o <= r && ((f = u), (l = a));
		return e[f];
	}
	function Y(t, e, r, i, n, o, a) {
		if ("auto" === t.end) return t;
		var s,
			c,
			u = t.end;
		if (((r = isNaN(r) ? B : r), (i = isNaN(i) ? -B : i), M(e))) {
			if (
				((s = e.calculated ? e : (N(u) ? u(e, a) : X(e, u, r, i, o)) || e),
				!e.calculated)
			) {
				for (c in s) e[c] = s[c];
				e.calculated = !0;
			}
			s = s[n];
		} else s = N(u) ? u(e, a) : w(u) ? X(e, u, r, i, o) : parseFloat(u);
		return (
			r < s ? (s = r) : s < i && (s = i),
			{ max: s, min: s, unitFactor: t.unitFactor }
		);
	}
	function Z(t, e, r) {
		return isNaN(t[e]) ? r : +t[e];
	}
	function $(t, e) {
		return (0.05 * e * t) / T;
	}
	function _(t, e, r) {
		return Math.abs(((e - t) * T) / r / 0.05);
	}
	function ba(t, e, r, i) {
		if (e.linkedProps) {
			var n,
				o,
				a,
				s,
				c,
				u,
				f = e.linkedProps.split(","),
				l = {};
			for (n = 0; n < f.length; n++)
				(a = e[(o = f[n])]) &&
					((s = L(a.velocity)
						? a.velocity
						: (c = c || j(t)) && c.isTracking(o)
						? c.get(o)
						: 0),
					(u = Math.abs(s / Z(a, "resistance", i))),
					(l[o] = parseFloat(r(t, o)) + $(s, u)));
			return l;
		}
	}
	function da() {
		(h = J()) &&
			((y = h.parseEase),
			(F = h.utils.toArray),
			(b = h.utils.getUnit),
			(O = h.core.getCache),
			(E = h.utils.clamp),
			(k = y("power3")),
			(T = k(0.05)),
			(A = h.core.PropTween),
			h.config({
				resistance: 100,
				unitFactors: {
					time: 1e3,
					totalTime: 1e3,
					progress: 1e3,
					totalProgress: 1e3,
				},
			}),
			(P = h.config()),
			h.registerPlugin(v),
			(x = 1));
	}
	var h,
		x,
		y,
		F,
		k,
		P,
		b,
		A,
		O,
		T,
		E,
		C,
		j = v.getByTarget,
		w = Array.isArray,
		B = 1e10,
		I = {
			resistance: 1,
			checkpoint: 1,
			preventOvershoot: 1,
			linkedProps: 1,
			radius: 1,
			duration: 1,
		},
		R = {
			version: "3.9.1",
			name: "inertia",
			register: function register(t) {
				(h = t), da();
			},
			init: function init(t, e, r, i, n) {
				x || da();
				var o = j(t);
				if ("auto" === e) {
					if (!o)
						return void console.warn(
							"No inertia tracking on " +
								t +
								". InertiaPlugin.track(target) first."
						);
					e = o.getAll();
				}
				(this.target = t), (this.tween = r), (C = e);
				var a,
					s,
					c,
					u,
					f,
					l,
					p,
					g,
					d,
					v = t._gsap,
					h = v.get,
					m = e.duration,
					y = M(m),
					k = e.preventOvershoot || (y && 0 === m.overshoot),
					T = Z(e, "resistance", P.resistance),
					w = L(m)
						? m
						: (function _calculateTweenDuration(t, e, r, i, n, o) {
								if (
									(void 0 === r && (r = 10),
									void 0 === i && (i = 0.2),
									void 0 === n && (n = 1),
									void 0 === o && (o = 0),
									(function _isString(t) {
										return "string" == typeof t;
									})(t) && (t = F(t)[0]),
									!t)
								)
									return 0;
								var a,
									s,
									c,
									u,
									f,
									l,
									p,
									g,
									d,
									v,
									h = 0,
									m = B,
									y = e.inertia || e,
									k = O(t).get,
									T = Z(y, "resistance", P.resistance);
								for (a in ((v = ba(t, y, k, T)), y))
									I[a] ||
										((s = y[a]),
										M(s) ||
											((g = g || j(t)) && g.isTracking(a)
												? (s = L(s) ? { velocity: s } : { velocity: g.get(a) })
												: ((u = +s || 0), (c = Math.abs(u / T)))),
										M(s) &&
											((u = L(s.velocity)
												? s.velocity
												: (g = g || j(t)) && g.isTracking(a)
												? g.get(a)
												: 0),
											(c = E(i, r, Math.abs(u / Z(s, "resistance", T)))),
											(l = (f = parseFloat(k(t, a)) || 0) + $(u, c)),
											"end" in s &&
												((s = Y(
													s,
													v && a in v ? v : l,
													s.max,
													s.min,
													a,
													y.radius,
													u
												)),
												o &&
													(C === e && (C = y = W(e)),
													(y[a] = V(s, y[a], "end")))),
											"max" in s && l > +s.max + 1e-10
												? ((d = s.unitFactor || P.unitFactors[a] || 1),
												  (p =
														(f > s.max && s.min !== s.max) ||
														(-15 < u * d && u * d < 45)
															? i + 0.1 * (r - i)
															: _(f, s.max, u)) +
														n <
														m && (m = p + n))
												: "min" in s &&
												  l < s.min - 1e-10 &&
												  ((d = s.unitFactor || P.unitFactors[a] || 1),
												  (p =
														(f < s.min && s.min !== s.max) ||
														(-45 < u * d && u * d < 15)
															? i + 0.1 * (r - i)
															: _(f, s.min, u)) +
														n <
														m && (m = p + n)),
											h < p && (h = p)),
										h < c && (h = c));
								return m < h && (h = m), r < h ? r : h < i ? i : h;
						  })(
								t,
								e,
								(y && m.max) || 10,
								(y && m.min) || 0.2,
								y && "overshoot" in m ? +m.overshoot : k ? 0 : 1,
								!0
						  );
				for (a in ((e = C), (C = 0), (d = ba(t, e, h, T)), e))
					I[a] ||
						((s = e[a]),
						N(s) && (s = s(i, t, n)),
						L(s)
							? (f = s)
							: M(s) && !isNaN(s.velocity)
							? (f = +s.velocity)
							: o && o.isTracking(a)
							? (f = o.get(a))
							: console.warn(
									"ERROR: No velocity was defined for " + t + " property: " + a
							  ),
						(l = $(f, w)),
						(g = 0),
						(c = h(t, a)),
						(u = b(c)),
						(c = parseFloat(c)),
						M(s) &&
							((p = c + l),
							"end" in s &&
								(s = Y(s, d && a in d ? d : p, s.max, s.min, a, e.radius, f)),
							"max" in s && +s.max < p
								? k || s.preventOvershoot
									? (l = s.max - c)
									: (g = s.max - c - l)
								: "min" in s &&
								  +s.min > p &&
								  (k || s.preventOvershoot
										? (l = s.min - c)
										: (g = s.min - c - l))),
						this._props.push(a),
						(this._pt = new A(this._pt, t, a, c, 0, Q, 0, v.set(t, a, this))),
						(this._pt.u = u || 0),
						(this._pt.c1 = l),
						(this._pt.c2 = g));
				return r.duration(w), 1;
			},
			render: function render(t, e) {
				var r = e._pt;
				for (t = k(e.tween._time / e.tween._dur); r; )
					r.set(r.t, r.p, U(r.s + r.c1 * t + r.c2 * t * t) + r.u, r.d, t),
						(r = r._next);
			},
		};
	"track,untrack,isTracking,getVelocity,getByTarget"
		.split(",")
		.forEach(function (t) {
			return (R[t] = v[t]);
		}),
		J() && h.registerPlugin(R),
		(e.InertiaPlugin = R),
		(e.VelocityTracker = v),
		(e.default = R);
	if (typeof window === "undefined" || window !== e) {
		Object.defineProperty(e, "__esModule", { value: !0 });
	} else {
		delete e.default;
	}
});

!(function (D, u) {
	"object" == typeof exports && "undefined" != typeof module
		? u(exports)
		: "function" == typeof define && define.amd
		? define(["exports"], u)
		: u(((D = D || self).window = D.window || {}));
})(this, function (D) {
	"use strict";
	var i = /(^\s+|\s+$)/g,
		A =
			/([\uD800-\uDBFF][\uDC00-\uDFFF](?:[\u200D\uFE0F][\uD800-\uDBFF][\uDC00-\uDFFF]){2,}|\uD83D\uDC69(?:\u200D(?:(?:\uD83D\uDC69\u200D)?\uD83D\uDC67|(?:\uD83D\uDC69\u200D)?\uD83D\uDC66)|\uD83C[\uDFFB-\uDFFF])|\uD83D\uDC69\u200D(?:\uD83D\uDC69\u200D)?\uD83D\uDC66\u200D\uD83D\uDC66|\uD83D\uDC69\u200D(?:\uD83D\uDC69\u200D)?\uD83D\uDC67\u200D(?:\uD83D[\uDC66\uDC67])|\uD83C\uDFF3\uFE0F\u200D\uD83C\uDF08|(?:\uD83C[\uDFC3\uDFC4\uDFCA]|\uD83D[\uDC6E\uDC71\uDC73\uDC77\uDC81\uDC82\uDC86\uDC87\uDE45-\uDE47\uDE4B\uDE4D\uDE4E\uDEA3\uDEB4-\uDEB6]|\uD83E[\uDD26\uDD37-\uDD39\uDD3D\uDD3E\uDDD6-\uDDDD])(?:\uD83C[\uDFFB-\uDFFF])\u200D[\u2640\u2642]\uFE0F|\uD83D\uDC69(?:\uD83C[\uDFFB-\uDFFF])\u200D(?:\uD83C[\uDF3E\uDF73\uDF93\uDFA4\uDFA8\uDFEB\uDFED]|\uD83D[\uDCBB\uDCBC\uDD27\uDD2C\uDE80\uDE92])|(?:\uD83C[\uDFC3\uDFC4\uDFCA]|\uD83D[\uDC6E\uDC6F\uDC71\uDC73\uDC77\uDC81\uDC82\uDC86\uDC87\uDE45-\uDE47\uDE4B\uDE4D\uDE4E\uDEA3\uDEB4-\uDEB6]|\uD83E[\uDD26\uDD37-\uDD39\uDD3C-\uDD3E\uDDD6-\uDDDF])\u200D[\u2640\u2642]\uFE0F|\uD83C\uDDFD\uD83C\uDDF0|\uD83C\uDDF6\uD83C\uDDE6|\uD83C\uDDF4\uD83C\uDDF2|\uD83C\uDDE9(?:\uD83C[\uDDEA\uDDEC\uDDEF\uDDF0\uDDF2\uDDF4\uDDFF])|\uD83C\uDDF7(?:\uD83C[\uDDEA\uDDF4\uDDF8\uDDFA\uDDFC])|\uD83C\uDDE8(?:\uD83C[\uDDE6\uDDE8\uDDE9\uDDEB-\uDDEE\uDDF0-\uDDF5\uDDF7\uDDFA-\uDDFF])|(?:\u26F9|\uD83C[\uDFCB\uDFCC]|\uD83D\uDD75)(?:\uFE0F\u200D[\u2640\u2642]|(?:\uD83C[\uDFFB-\uDFFF])\u200D[\u2640\u2642])\uFE0F|(?:\uD83D\uDC41\uFE0F\u200D\uD83D\uDDE8|\uD83D\uDC69(?:\uD83C[\uDFFB-\uDFFF])\u200D[\u2695\u2696\u2708]|\uD83D\uDC69\u200D[\u2695\u2696\u2708]|\uD83D\uDC68(?:(?:\uD83C[\uDFFB-\uDFFF])\u200D[\u2695\u2696\u2708]|\u200D[\u2695\u2696\u2708]))\uFE0F|\uD83C\uDDF2(?:\uD83C[\uDDE6\uDDE8-\uDDED\uDDF0-\uDDFF])|\uD83D\uDC69\u200D(?:\uD83C[\uDF3E\uDF73\uDF93\uDFA4\uDFA8\uDFEB\uDFED]|\uD83D[\uDCBB\uDCBC\uDD27\uDD2C\uDE80\uDE92]|\u2764\uFE0F\u200D(?:\uD83D\uDC8B\u200D(?:\uD83D[\uDC68\uDC69])|\uD83D[\uDC68\uDC69]))|\uD83C\uDDF1(?:\uD83C[\uDDE6-\uDDE8\uDDEE\uDDF0\uDDF7-\uDDFB\uDDFE])|\uD83C\uDDEF(?:\uD83C[\uDDEA\uDDF2\uDDF4\uDDF5])|\uD83C\uDDED(?:\uD83C[\uDDF0\uDDF2\uDDF3\uDDF7\uDDF9\uDDFA])|\uD83C\uDDEB(?:\uD83C[\uDDEE-\uDDF0\uDDF2\uDDF4\uDDF7])|[#\*0-9]\uFE0F\u20E3|\uD83C\uDDE7(?:\uD83C[\uDDE6\uDDE7\uDDE9-\uDDEF\uDDF1-\uDDF4\uDDF6-\uDDF9\uDDFB\uDDFC\uDDFE\uDDFF])|\uD83C\uDDE6(?:\uD83C[\uDDE8-\uDDEC\uDDEE\uDDF1\uDDF2\uDDF4\uDDF6-\uDDFA\uDDFC\uDDFD\uDDFF])|\uD83C\uDDFF(?:\uD83C[\uDDE6\uDDF2\uDDFC])|\uD83C\uDDF5(?:\uD83C[\uDDE6\uDDEA-\uDDED\uDDF0-\uDDF3\uDDF7-\uDDF9\uDDFC\uDDFE])|\uD83C\uDDFB(?:\uD83C[\uDDE6\uDDE8\uDDEA\uDDEC\uDDEE\uDDF3\uDDFA])|\uD83C\uDDF3(?:\uD83C[\uDDE6\uDDE8\uDDEA-\uDDEC\uDDEE\uDDF1\uDDF4\uDDF5\uDDF7\uDDFA\uDDFF])|\uD83C\uDFF4\uDB40\uDC67\uDB40\uDC62(?:\uDB40\uDC77\uDB40\uDC6C\uDB40\uDC73|\uDB40\uDC73\uDB40\uDC63\uDB40\uDC74|\uDB40\uDC65\uDB40\uDC6E\uDB40\uDC67)\uDB40\uDC7F|\uD83D\uDC68(?:\u200D(?:\u2764\uFE0F\u200D(?:\uD83D\uDC8B\u200D)?\uD83D\uDC68|(?:(?:\uD83D[\uDC68\uDC69])\u200D)?\uD83D\uDC66\u200D\uD83D\uDC66|(?:(?:\uD83D[\uDC68\uDC69])\u200D)?\uD83D\uDC67\u200D(?:\uD83D[\uDC66\uDC67])|\uD83C[\uDF3E\uDF73\uDF93\uDFA4\uDFA8\uDFEB\uDFED]|\uD83D[\uDCBB\uDCBC\uDD27\uDD2C\uDE80\uDE92])|(?:\uD83C[\uDFFB-\uDFFF])\u200D(?:\uD83C[\uDF3E\uDF73\uDF93\uDFA4\uDFA8\uDFEB\uDFED]|\uD83D[\uDCBB\uDCBC\uDD27\uDD2C\uDE80\uDE92]))|\uD83C\uDDF8(?:\uD83C[\uDDE6-\uDDEA\uDDEC-\uDDF4\uDDF7-\uDDF9\uDDFB\uDDFD-\uDDFF])|\uD83C\uDDF0(?:\uD83C[\uDDEA\uDDEC-\uDDEE\uDDF2\uDDF3\uDDF5\uDDF7\uDDFC\uDDFE\uDDFF])|\uD83C\uDDFE(?:\uD83C[\uDDEA\uDDF9])|\uD83C\uDDEE(?:\uD83C[\uDDE8-\uDDEA\uDDF1-\uDDF4\uDDF6-\uDDF9])|\uD83C\uDDF9(?:\uD83C[\uDDE6\uDDE8\uDDE9\uDDEB-\uDDED\uDDEF-\uDDF4\uDDF7\uDDF9\uDDFB\uDDFC\uDDFF])|\uD83C\uDDEC(?:\uD83C[\uDDE6\uDDE7\uDDE9-\uDDEE\uDDF1-\uDDF3\uDDF5-\uDDFA\uDDFC\uDDFE])|\uD83C\uDDFA(?:\uD83C[\uDDE6\uDDEC\uDDF2\uDDF3\uDDF8\uDDFE\uDDFF])|\uD83C\uDDEA(?:\uD83C[\uDDE6\uDDE8\uDDEA\uDDEC\uDDED\uDDF7-\uDDFA])|\uD83C\uDDFC(?:\uD83C[\uDDEB\uDDF8])|(?:\u26F9|\uD83C[\uDFCB\uDFCC]|\uD83D\uDD75)(?:\uD83C[\uDFFB-\uDFFF])|(?:\uD83C[\uDFC3\uDFC4\uDFCA]|\uD83D[\uDC6E\uDC71\uDC73\uDC77\uDC81\uDC82\uDC86\uDC87\uDE45-\uDE47\uDE4B\uDE4D\uDE4E\uDEA3\uDEB4-\uDEB6]|\uD83E[\uDD26\uDD37-\uDD39\uDD3D\uDD3E\uDDD6-\uDDDD])(?:\uD83C[\uDFFB-\uDFFF])|(?:[\u261D\u270A-\u270D]|\uD83C[\uDF85\uDFC2\uDFC7]|\uD83D[\uDC42\uDC43\uDC46-\uDC50\uDC66\uDC67\uDC70\uDC72\uDC74-\uDC76\uDC78\uDC7C\uDC83\uDC85\uDCAA\uDD74\uDD7A\uDD90\uDD95\uDD96\uDE4C\uDE4F\uDEC0\uDECC]|\uD83E[\uDD18-\uDD1C\uDD1E\uDD1F\uDD30-\uDD36\uDDD1-\uDDD5])(?:\uD83C[\uDFFB-\uDFFF])|\uD83D\uDC68(?:\u200D(?:(?:(?:\uD83D[\uDC68\uDC69])\u200D)?\uD83D\uDC67|(?:(?:\uD83D[\uDC68\uDC69])\u200D)?\uD83D\uDC66)|\uD83C[\uDFFB-\uDFFF])|(?:[\u261D\u26F9\u270A-\u270D]|\uD83C[\uDF85\uDFC2-\uDFC4\uDFC7\uDFCA-\uDFCC]|\uD83D[\uDC42\uDC43\uDC46-\uDC50\uDC66-\uDC69\uDC6E\uDC70-\uDC78\uDC7C\uDC81-\uDC83\uDC85-\uDC87\uDCAA\uDD74\uDD75\uDD7A\uDD90\uDD95\uDD96\uDE45-\uDE47\uDE4B-\uDE4F\uDEA3\uDEB4-\uDEB6\uDEC0\uDECC]|\uD83E[\uDD18-\uDD1C\uDD1E\uDD1F\uDD26\uDD30-\uDD39\uDD3D\uDD3E\uDDD1-\uDDDD])(?:\uD83C[\uDFFB-\uDFFF])?|(?:[\u231A\u231B\u23E9-\u23EC\u23F0\u23F3\u25FD\u25FE\u2614\u2615\u2648-\u2653\u267F\u2693\u26A1\u26AA\u26AB\u26BD\u26BE\u26C4\u26C5\u26CE\u26D4\u26EA\u26F2\u26F3\u26F5\u26FA\u26FD\u2705\u270A\u270B\u2728\u274C\u274E\u2753-\u2755\u2757\u2795-\u2797\u27B0\u27BF\u2B1B\u2B1C\u2B50\u2B55]|\uD83C[\uDC04\uDCCF\uDD8E\uDD91-\uDD9A\uDDE6-\uDDFF\uDE01\uDE1A\uDE2F\uDE32-\uDE36\uDE38-\uDE3A\uDE50\uDE51\uDF00-\uDF20\uDF2D-\uDF35\uDF37-\uDF7C\uDF7E-\uDF93\uDFA0-\uDFCA\uDFCF-\uDFD3\uDFE0-\uDFF0\uDFF4\uDFF8-\uDFFF]|\uD83D[\uDC00-\uDC3E\uDC40\uDC42-\uDCFC\uDCFF-\uDD3D\uDD4B-\uDD4E\uDD50-\uDD67\uDD7A\uDD95\uDD96\uDDA4\uDDFB-\uDE4F\uDE80-\uDEC5\uDECC\uDED0-\uDED2\uDEEB\uDEEC\uDEF4-\uDEF8]|\uD83E[\uDD10-\uDD3A\uDD3C-\uDD3E\uDD40-\uDD45\uDD47-\uDD4C\uDD50-\uDD6B\uDD80-\uDD97\uDDC0\uDDD0-\uDDE6])|(?:[#\*0-9\xA9\xAE\u203C\u2049\u2122\u2139\u2194-\u2199\u21A9\u21AA\u231A\u231B\u2328\u23CF\u23E9-\u23F3\u23F8-\u23FA\u24C2\u25AA\u25AB\u25B6\u25C0\u25FB-\u25FE\u2600-\u2604\u260E\u2611\u2614\u2615\u2618\u261D\u2620\u2622\u2623\u2626\u262A\u262E\u262F\u2638-\u263A\u2640\u2642\u2648-\u2653\u2660\u2663\u2665\u2666\u2668\u267B\u267F\u2692-\u2697\u2699\u269B\u269C\u26A0\u26A1\u26AA\u26AB\u26B0\u26B1\u26BD\u26BE\u26C4\u26C5\u26C8\u26CE\u26CF\u26D1\u26D3\u26D4\u26E9\u26EA\u26F0-\u26F5\u26F7-\u26FA\u26FD\u2702\u2705\u2708-\u270D\u270F\u2712\u2714\u2716\u271D\u2721\u2728\u2733\u2734\u2744\u2747\u274C\u274E\u2753-\u2755\u2757\u2763\u2764\u2795-\u2797\u27A1\u27B0\u27BF\u2934\u2935\u2B05-\u2B07\u2B1B\u2B1C\u2B50\u2B55\u3030\u303D\u3297\u3299]|\uD83C[\uDC04\uDCCF\uDD70\uDD71\uDD7E\uDD7F\uDD8E\uDD91-\uDD9A\uDDE6-\uDDFF\uDE01\uDE02\uDE1A\uDE2F\uDE32-\uDE3A\uDE50\uDE51\uDF00-\uDF21\uDF24-\uDF93\uDF96\uDF97\uDF99-\uDF9B\uDF9E-\uDFF0\uDFF3-\uDFF5\uDFF7-\uDFFF]|\uD83D[\uDC00-\uDCFD\uDCFF-\uDD3D\uDD49-\uDD4E\uDD50-\uDD67\uDD6F\uDD70\uDD73-\uDD7A\uDD87\uDD8A-\uDD8D\uDD90\uDD95\uDD96\uDDA4\uDDA5\uDDA8\uDDB1\uDDB2\uDDBC\uDDC2-\uDDC4\uDDD1-\uDDD3\uDDDC-\uDDDE\uDDE1\uDDE3\uDDE8\uDDEF\uDDF3\uDDFA-\uDE4F\uDE80-\uDEC5\uDECB-\uDED2\uDEE0-\uDEE5\uDEE9\uDEEB\uDEEC\uDEF0\uDEF3-\uDEF8]|\uD83E[\uDD10-\uDD3A\uDD3C-\uDD3E\uDD40-\uDD45\uDD47-\uDD4C\uDD50-\uDD6B\uDD80-\uDD97\uDDC0\uDDD0-\uDDE6])\uFE0F)/;
	function splitInnerHTML(D, u, F, C) {
		for (var E, e = D.firstChild, t = []; e; )
			3 === e.nodeType
				? ((E = (e.nodeValue + "").replace(/^\n+/g, "")),
				  C || (E = E.replace(/\s+/g, " ")),
				  t.push.apply(t, emojiSafeSplit(E, u, F, C)))
				: "br" === (e.nodeName + "").toLowerCase()
				? (t[t.length - 1] += "<br>")
				: t.push(e.outerHTML),
				(e = e.nextSibling);
		for (E = t.length; E--; ) "&" === t[E] && t.splice(E, 1, "&amp;");
		return t;
	}
	function emojiSafeSplit(D, u, F, C) {
		if (((D += ""), F && (D = D.replace(i, "")), u && "" !== u))
			return D.replace(/>/g, "&gt;").replace(/</g, "&lt;").split(u);
		for (var E, e, t = [], n = D.length, B = 0; B < n; B++)
			((55296 <= (e = D.charAt(B)).charCodeAt(0) && e.charCodeAt(0) <= 56319) ||
				(65024 <= D.charCodeAt(B + 1) && D.charCodeAt(B + 1) <= 65039)) &&
				((E = ((D.substr(B, 12).split(A) || [])[1] || "").length || 2),
				(e = D.substr(B, E)),
				(B += E - (t.emoji = 1))),
				t.push(
					">" === e
						? "&gt;"
						: "<" === e
						? "&lt;"
						: !C ||
						  " " !== e ||
						  (" " !== D.charAt(B - 1) && " " !== D.charAt(B + 1))
						? e
						: "&nbsp;"
				);
		return t;
	}
	var u,
		l,
		F = {
			version: "3.9.1",
			name: "text",
			init: function init(D, u, F) {
				var C,
					E,
					e,
					t,
					n,
					B,
					i,
					A,
					r = D.nodeName.toUpperCase(),
					s = this;
				if (
					((s.svg = D.getBBox && ("TEXT" === r || "TSPAN" === r)),
					!("innerHTML" in D || s.svg))
				)
					return !1;
				if (
					((s.target = D),
					"object" != typeof u && (u = { value: u }),
					"value" in u)
				) {
					for (
						s.delimiter = u.delimiter || "",
							e = splitInnerHTML(D, s.delimiter, !1, u.preserveSpaces),
							(l = l || document.createElement("div")).innerHTML = u.value,
							E = splitInnerHTML(l, s.delimiter),
							s.from = F._from,
							s.from && ((r = e), (e = E), (E = r)),
							s.hasClass = !(!u.newClass && !u.oldClass),
							s.newClass = u.newClass,
							s.oldClass = u.oldClass,
							C = (r = e.length - E.length) < 0 ? e : E,
							s.fillChar = u.fillChar || (u.padSpace ? "&nbsp;" : ""),
							r < 0 && (r = -r);
						-1 < --r;

					)
						C.push(s.fillChar);
					if ("diff" === u.type) {
						for (n = [], B = [], i = "", r = t = 0; r < E.length; r++)
							(A = E[r]) === e[r]
								? (i += A)
								: ((n[t] = i + A), (B[t++] = i + e[r]), (i = ""));
						(E = n), (e = B), i && (E.push(i), e.push(i));
					}
					u.speed &&
						F.duration(
							Math.min((0.05 / u.speed) * C.length, u.maxDuration || 9999)
						),
						(this.original = e),
						(this.text = E),
						this._props.push("text");
				} else s.text = s.original = [""];
			},
			render: function render(D, u) {
				1 < D ? (D = 1) : D < 0 && (D = 0), u.from && (D = 1 - D);
				var F,
					C,
					E,
					e = u.text,
					t = u.hasClass,
					n = u.newClass,
					B = u.oldClass,
					i = u.delimiter,
					A = u.target,
					r = u.fillChar,
					s = u.original,
					l = e.length,
					o = (D * l + 0.5) | 0;
				(E =
					t && D
						? ((C = B && o !== l),
						  ((F = n && o) ? "<span class='" + n + "'>" : "") +
								e.slice(0, o).join(i) +
								(F ? "</span>" : "") +
								(C ? "<span class='" + B + "'>" : "") +
								i +
								s.slice(o).join(i) +
								(C ? "</span>" : ""))
						: e.slice(0, o).join(i) + i + s.slice(o).join(i)),
					u.svg
						? (A.textContent = E)
						: (A.innerHTML =
								"&nbsp;" === r && ~E.indexOf("  ")
									? E.split("  ").join("&nbsp;&nbsp;")
									: E);
			},
		};
	(F.splitInnerHTML = splitInnerHTML),
		(F.emojiSafeSplit = emojiSafeSplit),
		(F.getText = function getText(D) {
			var u = D.nodeType,
				F = "";
			if (1 === u || 9 === u || 11 === u) {
				if ("string" == typeof D.textContent) return D.textContent;
				for (D = D.firstChild; D; D = D.nextSibling) F += getText(D);
			} else if (3 === u || 4 === u) return D.nodeValue;
			return F;
		}),
		(function _getGSAP() {
			return (
				u ||
				("undefined" != typeof window &&
					(u = window.gsap) &&
					u.registerPlugin &&
					u)
			);
		})() && u.registerPlugin(F),
		(D.TextPlugin = F),
		(D.default = F);
	if (typeof window === "undefined" || window !== D) {
		Object.defineProperty(D, "__esModule", { value: !0 });
	} else {
		delete D.default;
	}
});

function Spin2WinWheel() {

  gsap.registerPlugin(InertiaPlugin, TextPlugin, Draggable);

  var xmlns = "http://www.w3.org/2000/svg",
		xlinkns = "http://www.w3.org/1999/xlink",
		select = function (s) {
			return document.querySelector(s);
		},
		selectAll = function (s) {
			return document.querySelectorAll(s);
		},
		thisWheel = this,
		wheelSVG = select(".wheelSVG"),
		wheel = select(".wheel"),
		wheelOutline = select(".wheelOutline"),
		wheelContainer = select(".wheelContainer"),
		peg = select(".peg"),
		pegContainer = select(".pegContainer"),
		mainContainer = select(".mainContainer"),
		valueContainer = select(".valueContainer"),
		centerCircle = select(".centerCircle"),
		toast = select(".toast"),
		toastText = select(".toast p"),
		centerCircleImageContainer = select(".centerCircleImageContainer"),
		dataObj,
		svgWidth,
		svgHeight,
		wheelStrokeColor,
		wheelStrokeWidth,
		wheelFillColor = "transparent",
		wheelSize,
		wheelRadius,
		wheelTextColor,
		wheelTextOffsetY,
		wheelImageOffsetY,
		wheelTextSize,
		wheelImageSize,
		wheelDragger,
		currentWheelRotation,
		centerCircleStrokeColor,
		centerCircleStrokeWidth,
		centerCircleFillColor,
		centerCircleSize,
		centerCircleImageUrl,
		centerCircleImageWidth,
		centerCircleImageHeight,
		centerCircleRadius,
		segmentStrokeColor,
		segmentStrokeWidth,
		segmentValuesArray,
		numSegments,
		numSpins,
		rotationStep,
		segmentStep,
		oldWheelPos,
		currentWheelPos = 0,
		centerX,
		centerY,
		colorArray,
		spinCount = 0,
		spinMultiplier = 2,
		colorCount = 0,
		startAngle = 0,
		endAngle = startAngle,
		segmentArray = [],
		minSpinDuration,
		maxSpinDuration,
		gameOverText,
		invalidSpinText,
		introText,
		gameId,
		hasSound,
		hasShadows,
		clickToSpin,
		spinButton = null,
		onResult,
		onGameEnd,
		onError,
		spinInertiaPlugin,
		gameResultsArray = [],
		pegSnd = new Audio(
			"https://vainkeurz.com/wp-content/themes/t-vkrz/wheel-vkrz/media/wheel_tick.mp3"
		),
		spinDestinationArray,
		randomSpins = true,
		spinDirection, // = -1,
		numRevsPerDestination,
		invalidSpinThreshold,
		probabilityArray = null,
		hasProbability = false,
		requiredProb,
		restrictPlayDuration,
		initError1 =
			"Invalid destination set - please ensure the destination in spinDestinationArray is greater than 0 and less than or equal to the number of segments",
		initError2 =
			"Not enough segments. Please add more entries to segmentValuesArray",
		probabilityErrorStr =
			"If you have set JSON probability values they must add up to 100",
		disabledText,
		isDisabled = false,
		wheelProp = gsap.getProperty(".wheel"),
		initSpinVelocity = null,
		showErrorDelay = 0.1,
		setInitData = function () {
			wheelStrokeColor = dataObj.wheelStrokeColor;
			wheelSize = dataObj.wheelSize;
			wheelRadius = wheelSize / 2;
			wheelTextColor = dataObj.wheelTextColor;
			wheelStrokeColor = dataObj.wheelStrokeColor;
			wheelStrokeWidth = dataObj.wheelStrokeWidth;
			wheelTextOffsetY = dataObj.wheelTextOffsetY;
			wheelImageOffsetY = dataObj.wheelImageOffsetY;
			wheelImageSize = dataObj.wheelImageSize;
			wheelTextSize = dataObj.wheelTextSize;
			centerCircleStrokeColor = dataObj.centerCircleStrokeColor;
			centerCircleStrokeWidth = dataObj.centerCircleStrokeWidth;
			centerCircleFillColor = dataObj.centerCircleFillColor;
			centerCircleSize = dataObj.centerCircleSize;
			centerCircleRadius = centerCircleSize / 2;
			centerCircleImageUrl = dataObj.centerCircleImageUrl;
			centerCircleImageWidth = dataObj.centerCircleImageWidth;
			centerCircleImageHeight = dataObj.centerCircleImageHeight;
			segmentStrokeColor = dataObj.segmentStrokeColor;
			segmentStrokeWidth = dataObj.segmentStrokeWidth;
			segmentValuesArray = dataObj.segmentValuesArray;
			numSegments = segmentValuesArray.length;
			numSpins =
				dataObj.numSpins == -1 ? 9999999999999999 : parseInt(dataObj.numSpins);
			minSpinDuration = dataObj.minSpinDuration;
			maxSpinDuration =
				dataObj.maxSpinDuration <= dataObj.minSpinDuration
					? dataObj.minSpinDuration
					: dataObj.maxSpinDuration;
			gameOverText = dataObj.gameOverText;
			invalidSpinText = dataObj.invalidSpinText;
			introText = dataObj.introText;
			hasSound = dataObj.hasSound;
			gameId = dataObj.gameId;
			rotationStep = 360 / numSegments;
			segmentStep = rotationStep / 2;
			centerX = dataObj.centerX;
			centerY = dataObj.centerY;
			colorArray = dataObj.colorArray;
			hasShadows = dataObj.hasShadows;
			spinDestinationArray = dataObj.spinDestinationArray;
			spinDirection = dataObj.spinDirection === "cw" ? -1 : 1;
			clickToSpin = dataObj.clickToSpin;
			disabledText = dataObj.disabledText;
			//spinDirection = (clickToSpin) ? 1 : spinDirection;
			numRevsPerDestination = spinDirection * (3 * 360);
			//invalidSpinThreshold =  0.5;
			invalidSpinThreshold = 500;
			restrictPlayDuration = dataObj.restrictPlayDuration;
			if (hasShadows) {
				wheelOutline.setAttributeNS(null, "filter", "url(#shadow)");
				valueContainer.setAttributeNS(null, "filter", "url(#shadow)");
				centerCircle.setAttributeNS(null, "filter", "url(#shadow)");
				pegContainer.setAttributeNS(null, "filter", "url(#shadow)");
				toast.style.boxShadow = "0px 0px 20px rgba(21,21,21,0.5)";
			}
		},
		setInitPos = function () {
			gsap.set("svg", {
				visibility: "visible",
			});
			gsap.set(wheel, {
				svgOrigin: centerX + " " + centerY,
				x: 0,
				y: 0,
			});
			gsap.set(peg, {
				x: centerX - peg.getBBox().width / 2,
				y: centerY - wheelRadius - peg.getBBox().height / 2,
				transformOrigin: "50% 25%",
				visibility: "visible",
			});
			gsap.set(pegContainer, {
				transformOrigin: "50% 100%",
				scale: wheelSize / 600,
			});

			gsap.set(mainContainer, {
				svgOrigin: centerX + " " + centerY,
				rotation: -90,
				x: 0,
				y: 0,
			});
		},
		setCenterCircleImage = function () {
			//centerCircleImageContainer
			var centerCircleImage = document.createElementNS(xmlns, "image");
			centerCircleImage.setAttributeNS(
				xlinkns,
				"xlink:href",
				centerCircleImageUrl
			);
			centerCircleImage.setAttribute("width", centerCircleImageWidth);
			centerCircleImage.setAttribute("height", centerCircleImageHeight);
			centerCircleImage.setAttribute("x", centerX - centerCircleImageWidth / 2);
			centerCircleImage.setAttribute(
				"y",
				centerY - centerCircleImageHeight / 2
			);
			centerCircleImageContainer.appendChild(centerCircleImage);
		},
		setSpinDestinations = function () {
			//console.log(dataObj.numSpins)
			if (numSpins == 0) {
				showToast(disabledText);
				isDisabled = true;
				spinButton.onclick = null;

				return;
			}

			if (hasProbability) {
				return;
			}

			if (spinDestinationArray.length > 0) {
				randomSpins = false;
				numSpins = spinDestinationArray.length;
				for (var i = 0; i < spinDestinationArray.length; i++) {
					//check to see if the destination is available (if you set the destination to be more than the number of segments this will catch that)
					if (
						spinDestinationArray[i] > numSegments ||
						spinDestinationArray[i] === 0
					) {
						showInitError(initError1);

						return;
					}
					//make it zero based - this allows the author to set destinations using 1 as the first one (UX FTW!)
					spinDestinationArray[i] = spinDestinationArray[i] - 1;
					//ensure there is at least 2 spin revolutions (360 2 = 720) between destination spins
					spinDestinationArray[i] =
						spinDestinationArray[i] * -1 * rotationStep -
						numRevsPerDestination * spinMultiplier;
					//this multiplier increments to ensure the destination segment is indeed further around
					spinMultiplier += 2;
				}
			} else {
				//no else
			}

			//console.log(spinDestinationArray)

			if (clickToSpin) {
				createClickToSpin();
			} else {
				createDraggable();
			}

			showIntroText();
		},
		randomBetween = function (min, max) {
			return Math.floor(Math.random() * (max - min + 1) + min);
		},
		drawSegments = function () {
			var x1, x2, y1, y2, d, p, g, t, tn, destFill;
			for (var i = 0; i < numSegments; i++) {
				//startAngle = endAngle;
				startAngle = -segmentStep;
				endAngle = startAngle + rotationStep;

				x1 = centerX + wheelRadius * Math.cos((Math.PI * startAngle) / 180);
				y1 = centerY + wheelRadius * Math.sin((Math.PI * startAngle) / 180);
				x2 = centerX + wheelRadius * Math.cos((Math.PI * endAngle) / 180);
				y2 = centerY + wheelRadius * Math.sin((Math.PI * endAngle) / 180);

				d =
					"M" +
					centerX +
					"," +
					centerY +
					"  L" +
					x1 +
					"," +
					y1 +
					"  A" +
					wheelRadius +
					"," +
					wheelRadius +
					" 0 0,1 " +
					x2 +
					"," +
					y2 +
					"z";

				g = document.createElementNS(xmlns, "g");
				p = document.createElementNS(xmlns, "path");
				g.appendChild(p);
				//g.appendChild(t);
				wheel.appendChild(g);
				gsap.set(p, {
					rotation: i * rotationStep,
					svgOrigin: centerX + " " + centerY,
				});
				p.setAttributeNS(null, "d", d);

				//check if there are enough colors in the array to support the numer of segments
				if (colorArray[i]) {
					destFill = colorArray[i];
				} else {
					destFill = colorArray[colorCount];
					colorCount++;
					//if the extra color cycle count gets bigger than the number of listed colors set it back to 0 and start using them from the start (repeat the colors)
					if (colorCount == colorArray.length) {
						colorCount = 0;
					}
				}

				p.setAttributeNS(null, "fill", destFill);
				p.setAttributeNS(null, "stroke", 0);
				segmentArray.push({
					path: p,
					x1: x1,
					x2: x2,
					y1: y1,
					y2: y2,
				});
			} //end for

			if (segmentStrokeWidth > 0) {
				drawSegmentStrokes();
			}

			addValues();
		},
		drawSegmentStrokes = function () {
			for (var i = 0; i < numSegments; i++) {
				var l = document.createElementNS(xmlns, "line");
				l.setAttributeNS(null, "x1", centerX);
				l.setAttributeNS(null, "x2", segmentArray[i].x2);
				l.setAttributeNS(null, "y1", centerY);
				l.setAttributeNS(null, "y2", segmentArray[i].y2);
				l.setAttributeNS(null, "stroke", segmentStrokeColor);
				l.setAttributeNS(null, "stroke-width", segmentStrokeWidth);
				wheel.appendChild(l);

				gsap.set(l, {
					svgOrigin: centerX + " " + centerY,
					rotation: i * rotationStep,
				});
			}
		},
		addValues = function () {
			for (var i = 0; i < numSegments; i++) {
				var g = document.createElementNS(xmlns, "g");
				//var c = document.createElementNS(xmlns, 'circle');
				if (segmentValuesArray[i].type == "image") {
					var ig = document.createElementNS(xmlns, "image");
					g.appendChild(ig);
					ig.setAttribute("class", "wheelImage");
					ig.setAttributeNS(null, "x", centerX - wheelImageSize / 2);
					ig.setAttributeNS(
						null,
						"y",
						centerY - wheelRadius + wheelImageOffsetY
					);
					ig.setAttributeNS(null, "width", wheelImageSize);
					ig.setAttributeNS(null, "height", wheelImageSize);
					ig.setAttributeNS(xlinkns, "xlink:href", segmentValuesArray[i].value);
				} else if (segmentValuesArray[i].type == "string") {
					var t = document.createElementNS(xmlns, "text");

					var lines = segmentValuesArray[i].value.split("^"),
						tn,
						ts;

					lines.forEach(function (value, index) {
						tn = document.createTextNode(value);
						ts = document.createElementNS(xmlns, "tspan");

						ts.setAttributeNS(null, "dy", index ? "1.2em" : 0);

						ts.setAttributeNS(null, "x", centerX);

						ts.setAttributeNS(null, "text-anchor", "middle");

						ts.appendChild(tn);

						t.appendChild(ts);
					});

					g.appendChild(t);
					t.setAttribute("class", "wheelText");
					t.setAttributeNS(null, "fill", wheelTextColor);
					t.setAttributeNS(null, "x", centerX);
					t.setAttributeNS(null, "y", centerY - wheelRadius + wheelTextOffsetY);
					t.style.fontSize = wheelTextSize;
				}

				valueContainer.appendChild(g);

				gsap.set(g, {
					svgOrigin: centerX + " " + centerY,
					rotation: i * rotationStep,
				});
			}

			gsap.set(valueContainer, {
				svgOrigin: centerX + " " + centerY,
			});
		},
		getWheel = function () {
			var g = document.createElementNS(xmlns, "g");
			var c = document.createElementNS(xmlns, "circle");
			wheelOutline.appendChild(g);

			//wheel's outline
			c.setAttributeNS(null, "fill", wheelFillColor);
			c.setAttributeNS(null, "stroke", wheelStrokeColor);
			c.setAttributeNS(null, "stroke-width", wheelStrokeWidth);
			c.setAttributeNS(null, "cx", centerX);
			c.setAttributeNS(null, "cy", centerY);
			c.setAttributeNS(null, "r", wheelRadius);
			g.appendChild(c);

			return g;
		},
		getCenterCircle = function () {
			var c = document.createElementNS(xmlns, "circle");

			//circle's outline
			c.setAttributeNS(null, "fill", centerCircleFillColor);
			c.setAttributeNS(null, "stroke", centerCircleStrokeColor);
			c.setAttributeNS(null, "stroke-width", centerCircleStrokeWidth);
			c.setAttributeNS(null, "cx", centerX);
			c.setAttributeNS(null, "cy", centerY);
			c.setAttributeNS(null, "r", centerCircleRadius);

			return c;
		},
		onPegTweenStart = function () {
			pegSnd.play();
		},
		onWheelPress = function () {
			// popup.style.visibility = 'hidden';
			toast.style.visibility = "hidden";
		},
		onButtonPress = function () {
			toast.style.visibility = "hidden";
			spinButton.onclick = null;
			spinMultiplier += 2;
		},
		onWheelDragEnd = function () {
			initSpinVelocity = Math.abs(InertiaPlugin.getVelocity(wheel, "rotation"));
			//console.log('initSpinVelocity', initSpinVelocity);
			disableWheel();
			//prevent players dragging and dropping the wheel onto a segment
			if (randomSpins) {
				spinInertiaPlugin = InertiaPlugin.track(wheel, "rotation");
			}
		},
		throwUpdate = function (e) {
			//this deals with the peg ticker (at the top) and decides which direction it should flick
			//personally I think this is a nice touch - hope you do too!
			oldWheelPos = currentWheelPos;

			currentWheelPos = Math.round(wheelProp("rotation") / rotationStep);
			//peg code only
			if (currentWheelPos != oldWheelPos) {
				var rotation = currentWheelPos > oldWheelPos ? -35 : 35;

				gsap.fromTo(
					peg,
					{
						rotation: rotation,
					},
					{
						duration: 0.2,
						onStart: hasSound ? onPegTweenStart : null,
						rotation: 0,
						ease: "back",
					}
				);
			}
			//keep the values (images. text) sync'd with the wheel spinning
			gsap.set(valueContainer, {
				rotation: wheelProp("rotation"),
			});
		},
		throwComplete = function () {
			//work out where the wheel lands
			currentWheelRotation = wheelProp("rotation");
			var normalizedRotation = Math.round(currentWheelRotation % 360);
			normalizedRotation =
				normalizedRotation > 0 ? 360 - normalizedRotation : normalizedRotation;
			//console.log("complete", currentWheelRotation, normalizedRotation, InertiaPlugin.getVelocity(wheel, 'rotation'))

			normalizedRotation =
				normalizedRotation < 0
					? (normalizedRotation *= -1)
					: normalizedRotation;

			//check to see if spinInertiaPlugin exists (only when randomSpins = true)
			//console.log(spinInertiaPlugin, Math.abs(InertiaPlugin.getVelocity(wheel,'rotation')))
			if (spinInertiaPlugin && initSpinVelocity <= invalidSpinThreshold) {
				enableWheel();
				showResult("invalidSpin");
				return;
			}

			var segId = Math.round(normalizedRotation / rotationStep);
			var winningSegment = segmentArray[segId].path;

			showResult(Math.abs(segId));

			//randomSpins is true if no destinations have been set
			if (randomSpins) {
				//this means no destinations have been set
				if (numSpins > -1) {
					//this means no destinations have been set AND numSpins has been set to a positive number
					spinCount++;
				} else {
					//this means no destinations have been set AND numSpins is -1 meaning you can spin randomly forever
					//so stop executing anything else
					return;
				}
			} else {
				//this means destinations have been set
				spinCount++;
				wheelDragger[0].vars.snap = [spinDestinationArray[spinCount]];
			}

			InertiaPlugin.untrack(wheel);

			if (spinCount >= numSpins) {
				endGame();
				return;
			}

			enableWheel();
		},
		updateWheelBounds = function () {
			if (clickToSpin) return;

			wheelDragger[0].applyBounds({
				minRotation: spinDirection * -9999999999999999,
				maxRotation: currentWheelRotation,
			});
		},
		getRandomSpinFunction = function (multiplier) {
			var f = function (endValue) {
				//console.log(endValue)
				return Math.round(endValue / rotationStep) * rotationStep - multiplier;
			};
			return f;
		},
		getRandomClickSpin = function () {
			var val =
				-(rotationStep * randomBetween(0, numSegments)) -
				numRevsPerDestination * spinMultiplier;
			return val;
		},
		getProbabilityClickSpin = function () {
			var probId = Math.floor(Math.random() * probabilityArray.length);
			var probSeg = probabilityArray[probId];
			var val =
				-(rotationStep * probSeg) - numRevsPerDestination * spinMultiplier;

			return val;
		},
		createDraggable = function () {
			wheelDragger = Draggable.create(wheel, {
				type: "rotation",
				bounds: {
					minRotation: spinDirection * -9999999999999999,
					maxRotation: 0,
				},
				inertia: true,
				ease: "back(0.2)",
				snap: randomSpins
					? getRandomSpinFunction(0)
					: [spinDestinationArray[spinCount]],
				throwResistance: 0,
				minDuration: minSpinDuration,
				maxDuration: minSpinDuration,
				onThrowComplete: throwComplete,
				onPress: onWheelPress,
				onDrag: throwUpdate,
				onThrowUpdate: throwUpdate,
				//overshootTolerance: 1,
				onDragEnd: onWheelDragEnd,
			});
		},
		checkHasProbability = function () {
			hasProbability = true;
			segmentValuesArray.forEach(function (el, val) {
				//console.log(!isNaN(el.probability))
				//if(!el.probability){
				if (isNaN(el.probability)) {
					hasProbability = false;
					//return false;
				}
			});

			if (hasProbability) {
				spinDestinationArray = []; //, numSpins)
				numSpins =
					dataObj.numSpins == -1
						? 9999999999999999
						: parseInt(dataObj.numSpins);
				checkProbabilityValues();
			}
		},
		checkProbabilityValues = function () {
			var totalProb = 0; //, requiredProb = 100;

			segmentValuesArray.forEach(function (el, val) {
				totalProb += el.probability;
			});

			requiredProb = totalProb;

			if (
				Math.ceil(totalProb) == requiredProb ||
				Math.floor(totalProb) == requiredProb
			) {
				createProbabilityArray();
			} else {
				var r = confirm(
					"Total probability: " + totalProb + " - " + probabilityErrorStr
				);
				if (r == true) {
					gsap.set(wheelContainer, {
						autoAlpha: 0,
					});
					gsap.set(wheelContainer, {
						autoAlpha: 0,
					});
				}
			}
		};

    createProbabilityArray = function(){

      
      probabilityArray = [];

      segmentValuesArray.forEach( function(el, val){
        
        for(var i = 0; i < el.probability; i++){

          probabilityArray.push(val);
        }
      })



    },

    showProbabilityError = function (){


    },
    createClickToSpin = function(){

      if(checkHasProbability()){

        createProbabilityArray();
      }
      //check to see if the author called setSpinTrigger before init();
      //if spinTrigger is defined then they set it before
      //if it's not then we set wheel to be the button. Later the author may
      //overwrite this with their own button
      if(spinButton){
        spinButton.onclick = getTrigger();
      } else {
        spinButton = wheel;
        wheel.onclick = getTrigger();        
      } 

    
      },
    getTrigger = function(){
         return function(){

          if(hasProbability){

          gsap.to(wheel, {
            inertia:{
            	duration:{min:minSpinDuration, max:maxSpinDuration},
              rotation:{
                velocity:spinDirection * randomBetween(-700, -500), 
                //if it's random spins then get a random spin but pass in the multiplier to ensure a long spin (plus the right slot id)
                //if it has destinations set then use those
                end:getProbabilityClickSpin()
                //end:dest
              }
            },
            onStart:onButtonPress,
            onUpdate:throwUpdate,
            ease: Back.easeOut.config(0.2),
            //overshootTolerance:0,
            onComplete:spinComplete
          });  
            
          } else {

          var dest = -rotationStep * 2;
         
          gsap.to(wheel, {
            inertia:{
            	duration:{min:minSpinDuration, max:maxSpinDuration},
              rotation:{
                velocity:spinDirection * randomBetween(-700, -500), 
                //if it's random spins then get a random spin but pass in the multiplier to ensure a long spin (plus the right slot id)
                //if it has destinations set then use those
                end:(randomSpins) ? getRandomClickSpin(): [spinDestinationArray[spinCount]]
                //end:dest
              }
            },
            onStart:onButtonPress,
            onUpdate:throwUpdate,
            ease: Back.easeOut.config(0.2),
            //overshootTolerance:0,
            onComplete:spinComplete
          }); 

          }         
        }      
    },
    spinComplete = function() {

      //work out where the wheel lands
      currentWheelRotation = wheelProp('rotation');
      var normalizedRotation = Math.round(currentWheelRotation % 360);
      normalizedRotation = (normalizedRotation > 0) ? 360 - normalizedRotation : normalizedRotation;

      normalizedRotation = (normalizedRotation < 0) ? normalizedRotation *= -1 : normalizedRotation;        
      
      var segId = Math.round(normalizedRotation / rotationStep);
      var winningSegment = segmentArray[segId].path;

      showResult(Math.abs(segId));
      
      //randomSpins is true if no destinations have been set
      if (randomSpins) {
        //this means no destinations have been set        
        if (numSpins > -1) {
          //this means no destinations have been set AND numSpins has been set to a positive number          
          spinCount++;
          
        } else {
          //this means no destinations have been set AND numSpins is -1 meaning you can spin randomly forever
          //so stop executing anything else
          return;
        }
      } else {
        //this means destinations have been set
        spinCount++;

      }

      if (spinCount >= numSpins) {
        endGame();
        return;
      }
      
      spinButton.onclick = getTrigger();
    },      
    endGame = function() {

      //prevent the wheel being dragged once the game has finished
      disableWheel();

      gsap.set(wheelSVG, {
        opacity: 0.3
      })

      //show the gameOver text after 4 seconds
      gsap.to(toastText, {
        duration: 1,
        text: gameOverText,
        ease: Linear.easeNone,
        delay: 2
      })

      onGameEnd({gameId:gameId, target:thisWheel, results:gameResultsArray});

    },
    disableWheel = function() {
      if(clickToSpin)return;
      wheelDragger[0].disable();
    },
    enableWheel = function() {
      if(clickToSpin)return;
      wheelDragger[0].enable();
    },
    showResult = function(e) {
      
      updateWheelBounds();
      
      var resultObj;
      //if it's an error 
      if (e == "invalidSpin") {

        gsap.set(wheel, {
            rotation: spinDestinationArray[spinCount]
          })
        showToast(invalidSpinText);
        //create a result object 
        resultObj = {target:thisWheel, type:'error', spinCount:spinCount, win:null, msg:invalidSpinText, gameId:gameId};

        //fire the error event
        onError(resultObj);
        
        //add result to gameResultsArray
        gameResultsArray.push(resultObj);
                   
        return;
      }
      //if it's a number then it's a segment
      if (!isNaN(e)) {
        //the JSON contains a property that defines whether the segment is a winner or loser. Useful for backend decisions.
        //var resultStr1 = (segmentValuesArray[e].win) ? 'WIN:' : 'LOSE:';
        var resultStr2 = segmentValuesArray[e].resultText;

        showToast(resultStr2);
        //create a result object 
        resultObj = {target:thisWheel, type:'result', spinCount:spinCount, win:segmentValuesArray[e].win, msg:segmentValuesArray[e].resultText, gameId:gameId, userData:segmentValuesArray[e].userData};
        
        //fire the result event
        onResult(resultObj);
        
        //add result to gameResultsArray
        gameResultsArray.push(resultObj);
      }
    },
    showIntroText = function(str) {
      if(!dataObj.introTextVisible) return;
      showToast(introText);
    },
  showInitError = function(str) {
      gsap.set([wheelContainer, spinButton], {
        autoAlpha: 0
      }) 
      gsap.delayedCall(showErrorDelay, function(){
        alert(str)
      });     
    },
    showToast = function(str) {
      toast.style.visibility = 'visible';      
      toastText.innerHTML = str;
      gsap.fromTo(toast, {
        y: 20,
        opacity: 0
      }, {
        duration: 0.6,
        y: 0,
        opacity: 1,
        delay: 0.2,
        //onStart:onresize,
        ease: 'elastic(0.7, 0.7)'
      })
      
    },
    checkNumSegments = function() {

      if (numSegments <= 1) {
        showInitError(initError2)
        gsap.set(wheelSVG, {
          visibility: 'hidden'
        })
        
      }
      

    },
    setSpinTrigger = function(){  
      
      if(spinButton){
        clickToSpin = true;
      }
      if(clickToSpin){
        
        if(spinButton){
          spinButton.onclick = getTrigger(); 
        } else {
          
          wheel.onclick = getTrigger(); 
        }               
      } else {
        
      }
  },
  checkRestriction = function(){
    
      //if (restrictPlayDuration > 0) {
        onRestrict(restrictPlayDuration);
        
      //}    
  },  
    onResult = function(e){
        thisWheel.onResult(e)
      },
   onError = function(e){
        thisWheel.onError(e)
      },
   onGameEnd = function(e){
        thisWheel.onGameEnd(e)
      },
    onRestrict = function(e){
        thisWheel.onRestrict(e)
      } 
 
  this.onResult = onResult;
  this.onError = onError;
  this.onGameEnd = onGameEnd;

  this.onRestrict = onRestrict;  
 
 
  this.getGameProgress = function(){  return gameResultsArray; };
  this.init = function(e) {
  //if(String.fromCharCode(57,66,51).toLowerCase() !=  _s){_uu();}       
  //console.log(e)
    if(!e){
      setInitPos();
      showInitError('PLEASE INCLUDE THE INIT OBJECT');
      return;
    }
    svgWidth = e.data.svgWidth;
    svgHeight =  e.data.svgHeight;
    wheelSVG.setAttribute('viewBox', '0 0 ' + svgWidth + ' ' + e.data.svgHeight);
    dataObj = e.data;
    onGameEnd = (e.onGameEnd) ? e.onGameEnd : function(){};
    onResult =  (e.onResult) ? e.onResult : function(){};
    onError = (e.onError) ? e.onError : function(){};
    onRestrict = (e.onRestrict) ? e.onRestrict : function(){};
    spinButton = (e.spinTrigger) ? e.spinTrigger : null;
    setSpinTrigger();
    setInitData();

    onRestrict(restrictPlayDuration);
    
    setInitPos();
    drawSegments();
    setCenterCircleImage();
    wheelOutline.appendChild(getWheel())
    centerCircle.appendChild(getCenterCircle());
    setSpinDestinations();
    checkNumSegments();
    //checkRestriction();

    

    
    
    
  } 

  this.restart = function() {
    if(!clickToSpin){
        wheelDragger[0].kill();
        currentWheelPos = oldWheelPos = null;
        gsap.to([wheel, valueContainer], {
          duration: 0.3,
          rotation: '0_short',
          onComplete: createDraggable
        })      
    }
      
       gsap.set(wheelSVG, {
          opacity: 1
        })
        gsap.to([wheel, valueContainer],{
          duration: 0.3,
          rotation: '0_short'
        })      

      toast.style.visibility = 'hidden';
      spinCount = 0;
      spinMultiplier = 2;
      gameResultsArray = [];


      showIntroText();
  }

    
}

Spin2WinWheel.reset = function(){

      document.querySelector('.wheel').innerHTML = "";
      document.querySelector('.wheelOutline').innerHTML = "";
      document.querySelector('.centerCircle').innerHTML = "";
      document.querySelector('.valueContainer').innerHTML = "";
      document.querySelector('.centerCircleImageContainer').innerHTML = "";
      gsap.set(['.wheel', '.valueContainer'], {
        rotation: 0
      })      
     gsap.set(['.wheelSVG', '.toast'],{        
          opacity: gsap.utils.wrap([1, 0])        
      })


  }
  Spin2WinWheel.hide = function(){

      gsap.set('.wheelContainer', {
        autoAlpha:0
      })

  }  

  Spin2WinWheel.remove = function(){

      document.body.removeChild(document.querySelector('.wheelContainer'));

  }  
/*
  Spin2WinWheel.checkCookie = function(callback){

    var xobj = new XMLHttpRequest();
    xobj.open('GET', 'settings.php?f=checkCookie', true); 
    xobj.onreadystatechange = function() {
      if (xobj.readyState == 4 && xobj.status == "200") {
        callback(xobj.responseText)
        //successfully called IP check
        //0 means they haven't been here before
        // if(xobj.responseText == 0){

        //   callback();

        // } else{
        //   alert("Please come back and play tomorrow!");
        //   Spin2WinWheel.remove();
          
        //   //hide your button here too
        // }
      }
    };
    xobj.send(null);

  }

  Spin2WinWheel.setCookie = function(){

    var xobj = new XMLHttpRequest();
    xobj.open('GET', 'settings.php?f=setCookie', true); 
    xobj.onreadystatechange = function() {
      if (xobj.readyState == 4 && xobj.status == "200") {
        console.log(xobj.responseText)
        //successfully called IP check
        //0 means they haven't been here before
 
      }
    };    
    xobj.send(null);    
  }*/

 firebase.auth().onAuthStateChanged((user) => {
		const wheel = document.querySelector(".wheel-blur-container");
		const mustLogIn = document.querySelector(".must-log-in");

		if (!user) {
			if (wheel) {
				wheel.classList.add("disable-wheel");
			}
			if (mustLogIn) {
				mustLogIn.classList.remove("d-none");
			}
		}
 });

 //Usage
 let hasUserSpun = false;

 // Get currentGameId from URL
 const queryString = window.location.search;
 const urlParams = new URLSearchParams(queryString);
 const currentGameId = urlParams.get("idjeu") || "default_game_id"; // Use a default value if parameter is not found

 console.log(`Current Game ID is: ${currentGameId}`);

 // Function to load JSON data
 function loadJSON(callback) {
		var xobj = new XMLHttpRequest();
		xobj.overrideMimeType("application/json");
		xobj.open(
			"GET",
			"../wp-content/themes/t-vkrz/4-wheel/wheel_data.json",
			true
		);
		xobj.onreadystatechange = function () {
			if (xobj.readyState == 4 && xobj.status == "200") {
				callback(xobj.responseText);
			}
		};
		xobj.send(null);
 }

 function getUserInfo() {
		try {
			const userInfo = localStorage.getItem("user_info");
			return userInfo ? JSON.parse(userInfo) : null;
		} catch (error) {
			console.error("Error accessing localStorage:", error);
			return null;
		}
 }

 // Get the spin button and add an event listener
 const spinButton = document.querySelector(".spinBtn");
 if (spinButton) {
		spinButton.addEventListener("click", function () {
			this.disabled = true; // Disable the button when clicked
		});
 }

 function sendPostRequest(url, data) {
		return new Promise((resolve, reject) => {
			const xhr = new XMLHttpRequest();
			xhr.open("POST", url);
			xhr.setRequestHeader("Content-Type", "application/json");

			xhr.onload = function () {
				if (this.status >= 200 && this.status < 300) {
					resolve(JSON.parse(xhr.responseText));
				} else {
					reject(new Error("Status:" + this.status + " " + xhr.statusText));
				}
			};

			xhr.onerror = function () {
				reject(new Error("Network Error"));
			};

			xhr.send(JSON.stringify(data));
		});
 }

 function showWinOverlay(result) {
		const message = result.msg;
		const messageElements = document.querySelectorAll(
			".message_de_confirmation h3"
		);

		messageElements.forEach(function (element) {
			element.textContent = message;
		});
		// Select both popups
		const keurzPopup = document.querySelector(".participation-keurz");
		const nonKeurzPopup = document.querySelector(".participation-non-keurz");

		// Using a regular expression to check for ' KEURZ ' as a whole word
		const keurzRegex = /\bkeurz\b/i; // \b denotes a word boundary in regex
		// Check the content of the message using the regular expression
		if (keurzRegex.test(message)) {
			// Show KEURZ popup
			if (keurzPopup) {
				keurzPopup.classList.remove("d-none");
			}
			if (nonKeurzPopup) {
				nonKeurzPopup.classList.add("d-none");
			}
		} else {
			// Show Non-KEURZ popup
			if (nonKeurzPopup) {
				nonKeurzPopup.classList.remove("d-none");
			}
			if (keurzPopup) {
				keurzPopup.classList.add("d-none");
			}
		}
 }

 // Function to handle the result of the wheel spin
 function myResult(e) {
		// Log the spin count, win status, and message
		console.log(
			"Spin Count: " +
				e.spinCount +
				" - " +
				"Win: " +
				e.win +
				" - " +
				"Message: " +
				e.msg
		);

		// Check if userData and its score property are defined
		if (e.userData && e.userData.score) {
			onWheelStop(e.userData.score, e.userData); // Pass userData to onWheelStop
			showWinOverlay(e);
			const userInfos = getUserInfo();
			refresh_user_info(userInfos.uuid_user);
		}
 }

 // Function to handle any errors during the wheel spin
 function myError(e) {
		console.log("Spin Count: " + e.spinCount + " - " + "Message: " + e.msg);
 }

 // Function to handle the end of the game
 function myGameEnd(e) {
		console.log(e);
 }

 // Function to call after the wheel stops spinning
 function onWheelStop(lot, userData) {
		const user_infos = getUserInfo();
		if (user_infos && !hasUserSpun) {
			const postDataWheel = {
				id_user: user_infos.id,
				uuid: user_infos.uuid_user,
				lot: lot,
				idjeu: currentGameId,
			};

			const postDataRecompense = {
				name: "roue",
				uuid_vainkeur: user_infos.uuid_user,
				keurz: userData.scoreValue, // Use scoreValue instead of score
			};

			// Check if lot contains "KEURZ" as a whole word
			if (/\bkeurz\b/i.test(lot)) {
				// Send POST request to server for recompense
				sendPostRequest(
					`${API_BASE_URL}recompense-list/new`,
					postDataRecompense
				)
					.then((data) => {
						console.log("Response from server:", data);
						hasUserSpun = true;
					})
					.catch((error) => {
						console.error("Error:", error);
					});
			}

			// Send POST request for wheel spin
			sendPostRequest(`${API_BASE_URL}wheel`, postDataWheel)
				.then((data) => {
					hasUserSpun = true;
				})
				.catch((error) => {
					console.error("Error:", error);
				});
		} else {
			console.log("User has already spun or user info is missing.");
		}
 }

 // Function to check if the user has already spun the wheel
 function checkIfUserHasSpun(uuid, idjeu, callback) {
		fetch(`${API_BASE_URL}check-wheel`, {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({ uuid: uuid, idjeu: idjeu }),
		})
			.then((response) => response.json())
			.then((data) => callback(data.hasSpun))
			.catch((error) => {
				console.error("Error:", error);
				callback(false);
			});
 }

 // Initialization function
 function init() {
		const user_infos = getUserInfo();
		console.log(user_infos);

		function initializeWheel() {
			loadJSON(function (response) {
				var jsonData = JSON.parse(response);
				var myWheel = new Spin2WinWheel();
				myWheel.init({
					data: jsonData,
					onResult: myResult,
					onGameEnd: myGameEnd,
					onError: myError,
					spinTrigger: document.querySelector(".spinBtn"),
				});
				// Show spinBtn and peg after initializing the wheel
				const spinButton = document.querySelector(".spinBtn");
				const pegContainer = document.querySelector(".pegContainer");
				if (spinButton) {
					spinButton.style.display = "block";
				}
				if (pegContainer) {
					pegContainer.style.display = "block";
				}
			});
		}

		function showAlreadySpunToast() {
			document.querySelector(".wheel-blur-container").classList.add("disabled");
			const toast = document.querySelector(".toast");
			const toastP = document.querySelector(".toast p");
			toastP.textContent =
				"Tu as dÃ©jÃ  participÃ© ! Attends le prochain jeu pour tenter ta chance ðŸ’ª"; // Set your message here
			toast.style.display = "block";
		}

		if (user_infos) {
			checkIfUserHasSpun(
				user_infos.uuid_user,
				currentGameId,
				function (hasSpun) {
					hasUserSpun = hasSpun;
					const spinButton = document.querySelector(".spinBtn");
					if (hasUserSpun) {
						spinButton.disabled = true;
						showAlreadySpunToast();
					} else {
						initializeWheel();
					}
				}
			);
		} else {
			initializeWheel();
		}
 }

 // Ensure that the DOM is fully loaded before initializing
 document.addEventListener("DOMContentLoaded", init);

