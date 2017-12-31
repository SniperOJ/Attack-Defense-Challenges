(function() {
  var Markdown,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    __slice = [].slice;

  Markdown = (function(_super) {
    __extends(Markdown, _super);

    Markdown.prototype.opts = {
      markdown: false
    };

    function Markdown() {
      var args;
      args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
      Markdown.__super__.constructor.apply(this, args);
      this.editor = this.widget;
    }

    Markdown.prototype._init = function() {
      var hooks;
      if (!this.opts.markdown) {
        return;
      }
      if (typeof this.opts.markdown === "object") {
        hooks = $.extend({}, this.hooks, this.opts.markdown);
      } else {
        hooks = $.extend({}, this.hooks);
      }
      return this.editor.on("keypress", (function(_this) {
        return function(e) {
          var $blockEl, button, cmdEnd, cmdStart, container, content, hook, match, name, range, result, testRange;
          if (!(e.which === 32 || e.which === 13)) {
            return;
          }
          range = _this.editor.selection.getRange();
          container = range != null ? range.commonAncestorContainer : void 0;
          if (!(range && range.collapsed && container && container.nodeType === 3 && !$(container).parent("pre").length)) {
            return;
          }
          content = container.textContent;
          for (name in hooks) {
            hook = hooks[name];
            if (e.which === 13 && !hook.enterKey) {
              return;
            }
            if (!(hook && hook.cmd instanceof RegExp)) {
              continue;
            }
            match = content.match(hook.cmd);
            if (!match) {
              continue;
            }
            button = _this.editor.toolbar.findButton(name);
            if (button === null || button.disabled) {
              continue;
            }
            if (hook.block) {
              $blockEl = _this.editor.util.closestBlockEl(container);
              testRange = document.createRange();
              testRange.setStart(container, 0);
              testRange.collapse(true);
              if (!_this.editor.selection.rangeAtStartOf($blockEl, testRange)) {
                continue;
              }
            }
            cmdStart = match.index;
            cmdEnd = match[0].length + match.index;
            range.setStart(container, cmdStart);
            range.setEnd(container, cmdEnd);
            if (hook.block) {
              range.deleteContents();
              if (_this.editor.util.isEmptyNode($blockEl)) {
                $blockEl.append(_this.editor.util.phBr);
              }
              _this.editor.selection.setRangeAtEndOf($blockEl);
            }
            result = hook.callback.call(_this, button, hook, range, match, $blockEl);
            if ((e.which === 32 || name === "code") && result) {
              e.preventDefault();
            }
            break;
          }
        };
      })(this));
    };

    Markdown.prototype.hooks = {
      title: {
        cmd: /^#+/,
        block: true,
        enterKey: true,
        callback: function(button, hook, range, match, $blockEl) {
          var level;
          level = Math.min(match[0].length, 3);
          return button.command("h" + level);
        }
      },
      blockquote: {
        cmd: /^>{1}/,
        block: true,
        enterKey: true,
        callback: function(button, hook, range, match, $blockEl) {
          return button.command();
        }
      },
      code: {
        cmd: /^`{3}/,
        block: true,
        enterKey: true,
        callback: function(button, hook, range, match, $blockEl) {
          return button.command();
        }
      },
      hr: {
        cmd: /^\*{3,}$|^\-{3,}$/,
        block: true,
        enterKey: true,
        callback: function(button, hook, range, match, $blockEl) {
          return button.command();
        }
      },
      bold: {
        cmd: /\*{2}([^\*]+)\*{2}$|_{2}([^_]+)_{2}$/,
        block: false,
        callback: function(button, hook, range, match) {
          var text, textNode;
          text = match[1] || match[2];
          textNode = document.createTextNode(text);
          this.editor.selection.selectRange(range);
          range.deleteContents();
          range.insertNode(textNode);
          range.selectNode(textNode);
          this.editor.selection.selectRange(range);
          document.execCommand("bold");
          this.editor.selection.setRangeAfter(textNode);
          document.execCommand("bold");
          this.editor.trigger("valuechanged");
          return this.editor.trigger("selectionchanged");
        }
      },
      italic: {
        cmd: /\*([^\*]+)\*$/,
        block: false,
        callback: function(button, hook, range, match) {
          var text, textNode;
          text = match[1] || match[2];
          textNode = document.createTextNode(text);
          this.editor.selection.selectRange(range);
          range.deleteContents();
          range.insertNode(textNode);
          range.selectNode(textNode);
          this.editor.selection.selectRange(range);
          document.execCommand("italic");
          this.editor.selection.setRangeAfter(textNode);
          document.execCommand("italic");
          this.editor.trigger("valuechanged");
          return this.editor.trigger("selectionchanged");
        }
      },
      ul: {
        cmd: /^\*{1}$|^\+{1}$|^\-{1}$/,
        block: true,
        callback: function(button, hook, range, match, $blockEl) {
          return button.command();
        }
      },
      ol: {
        cmd: /^[0-9][\.\u3002]{1}$/,
        block: true,
        callback: function(button, hook, range, match, $blockEl) {
          return button.command();
        }
      },
      image: {
        cmd: /!\[(.+)\]\((.+)\)$/,
        block: true,
        callback: function(button, hook, range, match) {
          return button.command(match[2]);
        }
      },
      link: {
        cmd: /\[(.+)\]\((.+)\)$|\<((.[^\[\]\(\)]+))\>$/,
        block: false,
        callback: function(hook, range, match) {
          var $link, url;
          url = match[2] || match[4];
          if (!/[a-zA-z]+:\/\/[^\s]*/.test(url)) {
            return false;
          }
          $link = $("<a/>", {
            text: match[1] || match[3],
            href: url,
            target: "_blank"
          });
          this.editor.selection.selectRange(range);
          range.deleteContents();
          range.insertNode($link[0]);
          this.editor.selection.setRangeAfter($link);
          this.editor.trigger("valuechanged");
          return this.editor.trigger("selectionchanged");
        }
      }
    };

    return Markdown;

  })(Plugin);

  Simditor.connect(Markdown);

}).call(this);
