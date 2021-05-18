"use strict";

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var __ = wp.i18n.__;
var _wp$element = wp.element,
    Component = _wp$element.Component,
    Fragment = _wp$element.Fragment;
var registerBlockType = wp.blocks.registerBlockType;
var _wp$blockEditor = wp.blockEditor,
    RichText = _wp$blockEditor.RichText,
    InspectorControls = _wp$blockEditor.InspectorControls,
    BlockControls = _wp$blockEditor.BlockControls,
    AlignmentToolbar = _wp$blockEditor.AlignmentToolbar,
    MediaUpload = _wp$blockEditor.MediaUpload,
    MediaUploadCheck = _wp$blockEditor.MediaUploadCheck;
var withSelect = wp.data.withSelect;
var _wp$components = wp.components,
    ToggleControl = _wp$components.ToggleControl,
    PanelBody = _wp$components.PanelBody,
    PanelRow = _wp$components.PanelRow,
    CheckboxControl = _wp$components.CheckboxControl,
    SelectControl = _wp$components.SelectControl,
    ColorPicker = _wp$components.ColorPicker,
    TextControl = _wp$components.TextControl,
    TextareaControl = _wp$components.TextareaControl,
    Toolbar = _wp$components.Toolbar,
    Button = _wp$components.Button,
    Placeholder = _wp$components.Placeholder,
    Disabled = _wp$components.Disabled,
    ResponsiveWrapper = _wp$components.ResponsiveWrapper;

var SidebannerEdit = /*#__PURE__*/function (_Component) {
  _inherits(SidebannerEdit, _Component);

  var _super = _createSuper(SidebannerEdit);

  function SidebannerEdit(_props) {
    var _this;

    _classCallCheck(this, SidebannerEdit);

    _this = _super.call(this, _props);

    _defineProperty(_assertThisInitialized(_this), "removeMedia", function () {
      props.setAttributes({
        mediaId: 0,
        mediaUrl: ''
      });
    });

    _defineProperty(_assertThisInitialized(_this), "onSelectMedia", function (media) {
      props.setAttributes({
        mediaId: media.id,
        mediaUrl: media.url
      });
    });

    _defineProperty(_assertThisInitialized(_this), "getInspectorControls", function () {
      var _this$props = _this.props,
          attributes = _this$props.attributes,
          setAttributes = _this$props.setAttributes;
      return /*#__PURE__*/React.createElement(InspectorControls, null, /*#__PURE__*/React.createElement(PanelBody, {
        title: "\u041D\u0430\u0441\u0442\u0440\u043E\u0439\u043A\u0438 \u0431\u043B\u043E\u043A\u0430",
        initialOpen: true
      }, /*#__PURE__*/React.createElement(PanelRow, null, /*#__PURE__*/React.createElement(SelectControl, {
        label: "\u0421 \u043A\u0430\u043A\u043E\u0439 \u0441\u0442\u043E\u0440\u043E\u043D\u044B \u0431\u0430\u043D\u043D\u0435\u0440?",
        value: attributes.bannerside,
        options: [{
          label: "Слева",
          value: "left"
        }, {
          label: "Справа",
          value: "right"
        }],
        onChange: function onChange(newval) {
          return setAttributes({
            bannerside: newval
          });
        }
      }))), /*#__PURE__*/React.createElement(PanelBody, {
        title: "\u0412\u044B\u0431\u043E\u0440 \u043A\u0430\u0440\u0442\u0438\u043D\u043A\u0438",
        initialOpen: true
      }, /*#__PURE__*/React.createElement("div", {
        className: "editor-post-featured-image"
      }, /*#__PURE__*/React.createElement(MediaUploadCheck, null, /*#__PURE__*/React.createElement(MediaUpload, {
        onSelect: onSelectMedia,
        value: attributes.mediaId,
        allowedTypes: ['image'],
        render: function render(_ref) {
          var open = _ref.open;
          return /*#__PURE__*/React.createElement(Button, {
            className: attributes.mediaId == 0 ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview',
            onClick: open
          }, attributes.mediaId == 0 && __('Choose an image', 'awp'), props.media != undefined && /*#__PURE__*/React.createElement(ResponsiveWrapper, {
            naturalWidth: props.media.media_details.width,
            naturalHeight: props.media.media_details.height
          }, /*#__PURE__*/React.createElement("img", {
            src: props.media.source_url
          })));
        }
      })), attributes.mediaId != 0 && /*#__PURE__*/React.createElement(MediaUploadCheck, null, /*#__PURE__*/React.createElement(MediaUpload, {
        title: __('Replace image', 'awp'),
        value: attributes.mediaId,
        onSelect: onSelectMedia,
        allowedTypes: ['image'],
        render: function render(_ref2) {
          var open = _ref2.open;
          return /*#__PURE__*/React.createElement(Button, {
            onClick: open,
            isDefault: true,
            isLarge: true
          }, __('Replace image', 'awp'));
        }
      })), attributes.mediaId != 0 && /*#__PURE__*/React.createElement(MediaUploadCheck, null, /*#__PURE__*/React.createElement(Button, {
        onClick: removeMedia,
        isLink: true,
        isDestructive: true
      }, __('Remove image', 'awp'))))));
    });

    _defineProperty(_assertThisInitialized(_this), "getBlockControls", function () {
      var _this$props2 = _this.props,
          attributes = _this$props2.attributes,
          setAttributes = _this$props2.setAttributes;
      return /*#__PURE__*/React.createElement(BlockControls, null, /*#__PURE__*/React.createElement(Toolbar, null, /*#__PURE__*/React.createElement(Button, {
        label: _this.state.editMode ? "Preview" : "Edit",
        icon: _this.state.editMode ? "format-image" : "edit",
        onClick: function onClick() {
          return _this.setState({
            editMode: !_this.state.editMode
          });
        }
      })));
    });

    _this.state = {
      editMode: true
    };
    return _this;
  }

  _createClass(SidebannerEdit, [{
    key: "render",
    value: function render() {
      var _this$props3 = this.props,
          attributes = _this$props3.attributes,
          setAttributes = _this$props3.setAttributes;
      return [this.getInspectorControls(), this.getBlockControls(), /*#__PURE__*/React.createElement("div", null, this.state.editMode && /*#__PURE__*/React.createElement(Fragment, null, /*#__PURE__*/React.createElement(RichText, {
        value: attributes.title,
        tagName: "h2",
        onChange: function onChange(newtext) {
          return setAttributes({
            title: newtext
          });
        }
      }), /*#__PURE__*/React.createElement(RichText, {
        value: attributes.subtitle,
        tagName: "p",
        onChange: function onChange(newtext) {
          return setAttributes({
            subtitle: newtext
          });
        }
      })), !this.state.editMode && /*#__PURE__*/React.createElement("div", {
        className: "section"
      }, /*#__PURE__*/React.createElement("div", {
        className: attributes.bannerside + "side sidebanner"
      }), /*#__PURE__*/React.createElement("div", {
        className: "sidecontent"
      }, /*#__PURE__*/React.createElement(RichText.Content, {
        tagName: "h2",
        value: attributes.title
      }), /*#__PURE__*/React.createElement(RichText.Content, {
        tagName: "p",
        value: attributes.subtitle
      }))))];
    }
  }]);

  return SidebannerEdit;
}(Component);

registerBlockType("asp/sidebanner", {
  title: "Side Banner",
  category: "common",
  icon: "smiley",
  description: "Show a banner and text",
  keywords: ["example", "test"],
  attributes: {
    title: {
      type: "string",
      "default": "Заголовок"
    },
    subtitle: {
      type: "string",
      "default": "Описание",
      source: "html",
      selector: "p"
    },
    bannerside: {
      type: "string",
      "default": "left"
    },
    mediaId: {
      type: 'number',
      "default": 0
    },
    mediaUrl: {
      type: 'string',
      "default": ''
    }
  },
  edit: withSelect(function (select, props) {
    return {
      media: props.attributes.mediaId ? select('core').getMedia(props.attributes.mediaId) : undefined
    };
  })(SidebannerEdit),
  save: function save(props) {
    var attributes = props.attributes;
    return /*#__PURE__*/React.createElement("div", {
      className: "section"
    }, /*#__PURE__*/React.createElement("div", {
      className: attributes.bannerside + "side sidebanner"
    }), /*#__PURE__*/React.createElement("div", {
      className: "content"
    }, /*#__PURE__*/React.createElement(RichText.Content, {
      tagName: "h2",
      value: attributes.title
    }), /*#__PURE__*/React.createElement(RichText.Content, {
      tagName: "p",
      value: attributes.subtitle
    })));
  }
});