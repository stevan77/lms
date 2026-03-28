"""
Mini Pygame shim for browser Canvas rendering via Pyodide.
Supports: display, draw (line, circle, rect, ellipse, polygon, arc), Color, Surface.
"""

import js
from pyodide.ffi import to_js

_canvas = None
_ctx = None
_surfaces = {}
_screen = None
_initialized = False


class Color:
    def __init__(self, r, g=None, b=None, a=255):
        if isinstance(r, (list, tuple)):
            self.r, self.g, self.b = r[0], r[1], r[2]
            self.a = r[3] if len(r) > 3 else 255
        elif g is not None:
            self.r, self.g, self.b, self.a = r, g, b, a
        else:
            self.r, self.g, self.b, self.a = r, r, r, 255

    def __iter__(self):
        return iter((self.r, self.g, self.b, self.a))

    def to_css(self):
        return f"rgba({self.r},{self.g},{self.b},{self.a/255})"


def _color_to_css(color):
    if isinstance(color, Color):
        return color.to_css()
    if isinstance(color, (list, tuple)):
        r, g, b = color[0], color[1], color[2]
        a = color[3] / 255 if len(color) > 3 else 1
        return f"rgba({r},{g},{b},{a})"
    if isinstance(color, str):
        return color
    return f"rgb({color},{color},{color})"


class Rect:
    def __init__(self, x, y=None, w=None, h=None):
        if isinstance(x, (list, tuple)):
            self.x, self.y, self.w, self.h = x[0], x[1], x[2], x[3]
        elif isinstance(x, Rect):
            self.x, self.y, self.w, self.h = x.x, x.y, x.w, x.h
        else:
            self.x, self.y, self.w, self.h = x, y, w, h

    @property
    def left(self): return self.x
    @property
    def top(self): return self.y
    @property
    def right(self): return self.x + self.w
    @property
    def bottom(self): return self.y + self.h
    @property
    def width(self): return self.w
    @property
    def height(self): return self.h
    @property
    def center(self): return (self.x + self.w // 2, self.y + self.h // 2)
    @property
    def size(self): return (self.w, self.h)

    def __iter__(self):
        return iter((self.x, self.y, self.w, self.h))


class Surface:
    def __init__(self, size, canvas=None, ctx=None):
        self.width, self.height = size
        self._canvas = canvas
        self._ctx = ctx

    def get_size(self):
        return (self.width, self.height)

    def get_rect(self, **kwargs):
        r = Rect(0, 0, self.width, self.height)
        if 'center' in kwargs:
            cx, cy = kwargs['center']
            r.x = cx - self.width // 2
            r.y = cy - self.height // 2
        return r

    def fill(self, color):
        if self._ctx:
            self._ctx.fillStyle = _color_to_css(color)
            self._ctx.fillRect(0, 0, self.width, self.height)

    def blit(self, source, dest):
        pass  # simplified - no image blitting in shim

    def set_at(self, pos, color):
        if self._ctx:
            self._ctx.fillStyle = _color_to_css(color)
            self._ctx.fillRect(pos[0], pos[1], 1, 1)

    def get_at(self, pos):
        return (0, 0, 0, 255)


class _Display:
    @staticmethod
    def set_mode(size=(800, 600)):
        global _canvas, _ctx, _screen
        container = js.document.getElementById('pygame-canvas-container')
        if not container:
            return Surface(size)

        # Clear previous
        container.innerHTML = ''

        _canvas = js.document.createElement('canvas')
        _canvas.width = size[0]
        _canvas.height = size[1]
        _canvas.style.border = '1px solid #e5e7eb'
        _canvas.style.borderRadius = '8px'
        _canvas.style.display = 'block'
        _canvas.style.maxWidth = '100%'
        _canvas.style.backgroundColor = '#000000'
        container.appendChild(_canvas)

        _ctx = _canvas.getContext('2d')
        _screen = Surface(size, _canvas, _ctx)
        return _screen

    @staticmethod
    def flip():
        pass  # canvas updates immediately

    @staticmethod
    def update(rect=None):
        pass

    @staticmethod
    def set_caption(title):
        pass

    @staticmethod
    def get_surface():
        return _screen


class _Draw:
    @staticmethod
    def line(surface, color, start, end, width=1):
        ctx = surface._ctx
        if not ctx: return
        ctx.strokeStyle = _color_to_css(color)
        ctx.lineWidth = width
        ctx.lineCap = 'round'
        ctx.beginPath()
        ctx.moveTo(start[0], start[1])
        ctx.lineTo(end[0], end[1])
        ctx.stroke()

    @staticmethod
    def lines(surface, color, closed, points, width=1):
        ctx = surface._ctx
        if not ctx or len(points) < 2: return
        ctx.strokeStyle = _color_to_css(color)
        ctx.lineWidth = width
        ctx.lineCap = 'round'
        ctx.lineJoin = 'round'
        ctx.beginPath()
        ctx.moveTo(points[0][0], points[0][1])
        for p in points[1:]:
            ctx.lineTo(p[0], p[1])
        if closed:
            ctx.closePath()
        ctx.stroke()

    @staticmethod
    def rect(surface, color, rect, width=0, border_radius=0):
        ctx = surface._ctx
        if not ctx: return
        r = Rect(rect) if not isinstance(rect, Rect) else rect
        if width == 0:
            ctx.fillStyle = _color_to_css(color)
            if border_radius > 0:
                _Draw._rounded_rect(ctx, r.x, r.y, r.w, r.h, border_radius)
                ctx.fill()
            else:
                ctx.fillRect(r.x, r.y, r.w, r.h)
        else:
            ctx.strokeStyle = _color_to_css(color)
            ctx.lineWidth = width
            if border_radius > 0:
                _Draw._rounded_rect(ctx, r.x, r.y, r.w, r.h, border_radius)
                ctx.stroke()
            else:
                ctx.strokeRect(r.x, r.y, r.w, r.h)

    @staticmethod
    def _rounded_rect(ctx, x, y, w, h, r):
        ctx.beginPath()
        ctx.moveTo(x + r, y)
        ctx.lineTo(x + w - r, y)
        ctx.quadraticCurveTo(x + w, y, x + w, y + r)
        ctx.lineTo(x + w, y + h - r)
        ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h)
        ctx.lineTo(x + r, y + h)
        ctx.quadraticCurveTo(x, y + h, x, y + h - r)
        ctx.lineTo(x, y + r)
        ctx.quadraticCurveTo(x, y, x + r, y)
        ctx.closePath()

    @staticmethod
    def circle(surface, color, center, radius, width=0):
        ctx = surface._ctx
        if not ctx: return
        ctx.beginPath()
        ctx.arc(center[0], center[1], radius, 0, 2 * 3.14159265359)
        if width == 0:
            ctx.fillStyle = _color_to_css(color)
            ctx.fill()
        else:
            ctx.strokeStyle = _color_to_css(color)
            ctx.lineWidth = width
            ctx.stroke()

    @staticmethod
    def ellipse(surface, color, rect, width=0):
        ctx = surface._ctx
        if not ctx: return
        r = Rect(rect) if not isinstance(rect, Rect) else rect
        cx = r.x + r.w / 2
        cy = r.y + r.h / 2
        rx = r.w / 2
        ry = r.h / 2
        ctx.beginPath()
        ctx.ellipse(cx, cy, rx, ry, 0, 0, 2 * 3.14159265359)
        if width == 0:
            ctx.fillStyle = _color_to_css(color)
            ctx.fill()
        else:
            ctx.strokeStyle = _color_to_css(color)
            ctx.lineWidth = width
            ctx.stroke()

    @staticmethod
    def polygon(surface, color, points, width=0):
        ctx = surface._ctx
        if not ctx or len(points) < 3: return
        ctx.beginPath()
        ctx.moveTo(points[0][0], points[0][1])
        for p in points[1:]:
            ctx.lineTo(p[0], p[1])
        ctx.closePath()
        if width == 0:
            ctx.fillStyle = _color_to_css(color)
            ctx.fill()
        else:
            ctx.strokeStyle = _color_to_css(color)
            ctx.lineWidth = width
            ctx.stroke()

    @staticmethod
    def arc(surface, color, rect, start_angle, stop_angle, width=1):
        ctx = surface._ctx
        if not ctx: return
        r = Rect(rect) if not isinstance(rect, Rect) else rect
        cx = r.x + r.w / 2
        cy = r.y + r.h / 2
        rx = r.w / 2
        ry = r.h / 2
        ctx.beginPath()
        ctx.ellipse(cx, cy, rx, ry, 0, start_angle, stop_angle)
        ctx.strokeStyle = _color_to_css(color)
        ctx.lineWidth = width
        ctx.stroke()

    @staticmethod
    def aaline(surface, color, start, end, blend=1):
        _Draw.line(surface, color, start, end, 1)

    @staticmethod
    def aalines(surface, color, closed, points, blend=1):
        _Draw.lines(surface, color, closed, points, 1)


class _Font:
    class SysFont:
        def __init__(self, name, size):
            self.name = name or 'sans-serif'
            self.size = size

        def render(self, text, antialias=True, color=(0, 0, 0)):
            # Returns a mock surface; actual rendering happens via blit override
            return _TextSurface(text, self, color)

    @staticmethod
    def init():
        pass

    @staticmethod
    def get_fonts():
        return ['arial', 'sans-serif']


class _TextSurface(Surface):
    def __init__(self, text, font, color):
        self.text = text
        self.font = font
        self.color = color
        # Estimate size
        super().__init__((len(text) * font.size * 0.6, font.size * 1.2))


# Module-level attributes
display = _Display()
draw = _Draw()
font = _Font()

# Constants
QUIT = 256
KEYDOWN = 768
KEYUP = 769
K_ESCAPE = 27
K_RETURN = 13
K_SPACE = 32
K_UP = 273
K_DOWN = 274
K_LEFT = 276
K_RIGHT = 275
MOUSEBUTTONDOWN = 1025
MOUSEBUTTONUP = 1026


class _Event:
    def __init__(self, type, **kwargs):
        self.type = type
        for k, v in kwargs.items():
            setattr(self, k, v)


class event:
    @staticmethod
    def get():
        return []

    @staticmethod
    def pump():
        pass


class time:
    class Clock:
        def tick(self, fps=60):
            pass

    @staticmethod
    def wait(ms):
        pass

    @staticmethod
    def delay(ms):
        pass

    @staticmethod
    def get_ticks():
        return 0


class mouse:
    @staticmethod
    def get_pos():
        return (0, 0)

    @staticmethod
    def get_pressed():
        return (False, False, False)


class key:
    @staticmethod
    def get_pressed():
        return {}


def init():
    global _initialized
    _initialized = True
    return (6, 0)


def quit():
    global _initialized
    _initialized = False


# Override Surface.blit to handle text
_orig_blit = Surface.blit
def _new_blit(self, source, dest):
    if isinstance(source, _TextSurface) and self._ctx:
        ctx = self._ctx
        ctx.fillStyle = _color_to_css(source.color)
        ctx.font = f"{source.font.size}px {source.font.name}"
        ctx.textBaseline = 'top'
        pos = dest if isinstance(dest, (list, tuple)) else (dest.x, dest.y)
        ctx.fillText(source.text, pos[0], pos[1])
    else:
        _orig_blit(self, source, dest)
Surface.blit = _new_blit

# math constant
import math
math.pi  # ensure available
