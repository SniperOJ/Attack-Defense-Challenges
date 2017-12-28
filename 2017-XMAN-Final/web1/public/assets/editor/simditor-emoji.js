(function() {
  var EmojiButton,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    __slice = [].slice;

  EmojiButton = (function(_super) {
    __extends(EmojiButton, _super);

    EmojiButton.images = ['smile', 'smiley', 'laughing', 'blush', 'heart_eyes', 'smirk', 'flushed', 'satisfied', 'grin', 'wink', 'stuck_out_tongue_winking_eye', 'stuck_out_tongue', 'sleeping', 'worried', 'expressionless', 'sweat_smile', 'cold_sweat', 'joy', 'sob', 'angry', 'mask', 'scream', 'sunglasses', 'heart', 'broken_heart', 'star', 'anger', 'exclamation', 'question', 'zzz', 'thumbsup', 'thumbsdown', 'ok_hand', 'punch', 'v', 'clap', 'muscle', 'pray', 'skull', 'trollface'];

    EmojiButton.prototype.name = 'emoji';

    EmojiButton.prototype.icon = 'smile-o';

    EmojiButton.prototype.title = '表情';

    EmojiButton.prototype.htmlTag = 'img';

    EmojiButton.prototype.menu = true;

    function EmojiButton() {
      var args;
      args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
      EmojiButton.__super__.constructor.apply(this, args);
      $.merge(this.editor.formatter._allowedAttributes['img'], ['data-emoji', 'alt']);
    }

    EmojiButton.prototype.renderMenu = function() {
      var $list, dir, html, name, opts, tpl, _i, _len, _ref;
      tpl = '<ul class="emoji-list">\n</ul>';
      opts = $.extend({
        imagePath: 'images/emoji/',
        images: EmojiButton.images
      }, this.editor.opts.emoji || {});
      html = "";
      dir = opts.imagePath.replace(/\/$/, '') + '/';
      _ref = opts.images;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        name = _ref[_i];
        html += "<li data-name='" + name + "'><img src='" + dir + name + ".png' width='20' height='20' alt='" + name + "' /></li>";
      }
      $list = $(tpl);
      $list.html(html).appendTo(this.menuWrapper);
      return $list.on('mousedown', 'li', (function(_this) {
        return function(e) {
          var $img;
          _this.wrapper.removeClass('menu-on');
          if (!_this.editor.inputManager.focused) {
            return;
          }
          $img = $(e.currentTarget).find('img').clone().attr({
            'data-emoji': true,
            'data-non-image': true
          });
          _this.editor.selection.insertNode($img);
          _this.editor.trigger('valuechanged');
          _this.editor.trigger('selectionchanged');
          return false;
        };
      })(this));
    };

    return EmojiButton;

  })(SimditorButton);

  Simditor.Toolbar.addButton(EmojiButton);

}).call(this);
