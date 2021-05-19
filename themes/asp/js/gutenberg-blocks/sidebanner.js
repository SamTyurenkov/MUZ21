"use strict";

var __ = wp.i18n.__;
var _wp$element = wp.element,
    Component = _wp$element.Component,
    Fragment = _wp$element.Fragment;
var _wp = wp,
    ServerSideRender = _wp.serverSideRender;
var registerBlockType = wp.blocks.registerBlockType;
var _wp$blockEditor = wp.blockEditor,
    RichText = _wp$blockEditor.RichText,
    InspectorControls = _wp$blockEditor.InspectorControls,
    BlockControls = _wp$blockEditor.BlockControls,
    AlignmentToolbar = _wp$blockEditor.AlignmentToolbar,
    MediaUpload = _wp$blockEditor.MediaUpload,
    MediaUploadCheck = _wp$blockEditor.MediaUploadCheck;
var useSelect = wp.data.useSelect;
var _wp$components = wp.components,
    ToggleControl = _wp$components.ToggleControl,
    PanelBody = _wp$components.PanelBody,
    PanelRow = _wp$components.PanelRow,
    CheckboxControl = _wp$components.CheckboxControl,
    SelectControl = _wp$components.SelectControl,
    ColorPicker = _wp$components.ColorPicker,
    TextControl = _wp$components.TextControl,
    TextareaControl = _wp$components.TextareaControl,
    ToolbarGroup = _wp$components.ToolbarGroup,
    Button = _wp$components.Button,
    ToolbarButton = _wp$components.ToolbarButton,
    Placeholder = _wp$components.Placeholder,
    Disabled = _wp$components.Disabled,
    ResponsiveWrapper = _wp$components.ResponsiveWrapper; //class SidebannerEdit extends Component {

var SidebannerEdit = function SidebannerEdit(props) {
  var state = {
    editMode: true
  };
  var attributes = props.attributes,
      setAttributes = props.setAttributes;

  var _useSelect = useSelect(function (select, attributes) {
    return {
      media: attributes.mediaId ? select("core").getMedia(attributes.mediaId) : undefined
    };
  }),
      media = _useSelect.media;

  var removeMedia = function removeMedia() {
    setAttributes({
      mediaId: 0,
      mediaUrl: ""
    });
  };

  var onSelectMedia = function onSelectMedia(media) {
    setAttributes({
      mediaId: media.id,
      mediaUrl: media.url
    });
  };

  var getInspectorControls = function getInspectorControls() {
    return /*#__PURE__*/React.createElement(InspectorControls, null, /*#__PURE__*/React.createElement(PanelBody, {
      title: "\u041D\u0430\u0441\u0442\u0440\u043E\u0439\u043A\u0438 \u0431\u043B\u043E\u043A\u0430",
      initialOpen: true,
      key: 1
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
      initialOpen: true,
      key: 2
    }, /*#__PURE__*/React.createElement("div", {
      className: "editor-post-featured-image"
    }, /*#__PURE__*/React.createElement(MediaUploadCheck, {
      key: 1
    }, /*#__PURE__*/React.createElement(MediaUpload, {
      onSelect: onSelectMedia,
      value: attributes.mediaId,
      allowedTypes: ["image"],
      render: function render(_ref) {
        var open = _ref.open;
        return /*#__PURE__*/React.createElement(Button, {
          className: attributes.mediaId == 0 ? "editor-post-featured-image__toggle" : "editor-post-featured-image__preview",
          onClick: open
        }, attributes.mediaId == 0 && __("Choose an image", "awp"), attributes.media != undefined && /*#__PURE__*/React.createElement(ResponsiveWrapper, {
          naturalWidth: attributes.media.media_details.width,
          naturalHeight: attributes.media.media_details.height
        }, /*#__PURE__*/React.createElement("img", {
          src: attributes.media.source_url
        })));
      }
    })), attributes.mediaId != 0 && /*#__PURE__*/React.createElement(MediaUploadCheck, {
      key: 2
    }, /*#__PURE__*/React.createElement(MediaUpload, {
      title: __("Replace image", "awp"),
      value: attributes.mediaId,
      onSelect: onSelectMedia,
      allowedTypes: ["image"],
      render: function render(_ref2) {
        var open = _ref2.open;
        return /*#__PURE__*/React.createElement(Button, {
          onClick: open,
          isDefault: true
        }, __("Replace image", "awp"));
      }
    })), attributes.mediaId != 0 && /*#__PURE__*/React.createElement(MediaUploadCheck, {
      key: 3
    }, /*#__PURE__*/React.createElement(Button, {
      onClick: removeMedia,
      isLink: true,
      isDestructive: true
    }, __("Remove image", "awp"))))));
  };

  var getBlockControls = function getBlockControls() {
    return /*#__PURE__*/React.createElement(BlockControls, null, /*#__PURE__*/React.createElement(ToolbarGroup, null, /*#__PURE__*/React.createElement(ToolbarButton, {
      label: state.editMode ? "Preview" : "Edit",
      icon: state.editMode ? "format-image" : "edit",
      onClick: function onClick() {
        return state({
          editMode: !state.editMode
        });
      }
    })));
  };

  return [getInspectorControls(), getBlockControls(), /*#__PURE__*/React.createElement("div", null, state.editMode && /*#__PURE__*/React.createElement(Fragment, null, /*#__PURE__*/React.createElement(RichText, {
    key: 1,
    value: attributes.title,
    tagName: "h2",
    onChange: function onChange(newtext) {
      return setAttributes({
        title: newtext
      });
    }
  }), /*#__PURE__*/React.createElement(RichText, {
    key: 2,
    value: attributes.subtitle,
    tagName: "p",
    onChange: function onChange(newtext) {
      return setAttributes({
        subtitle: newtext
      });
    }
  })), !state.editMode && /*#__PURE__*/React.createElement(ServerSideRender, {
    block: attributes.name,
    attributes: {
      title: attributes.title,
      subtitle: attributes.subtitle,
      postlist: attributes.postlist,
      mediaUrl: attributes.mediaUrl
    }
  }))];
};

registerBlockType("asp/sidebanner", {
  title: "Side Banner",
  category: "common",
  icon: "smiley",
  description: "Show a banner and text",
  keywords: ["example", "test"],
  attributes: {
    blockname: {
      type: "string",
      "default": "sidebanner"
    },
    title: {
      type: "string",
      "default": "Заголовок"
    },
    subtitle: {
      type: "string",
      "default": "Описание"
    },
    bannerside: {
      type: "string",
      "default": "left"
    },
    mediaId: {
      type: "number",
      "default": 0
    },
    mediaUrl: {
      type: "string",
      "default": ""
    }
  },
  edit: SidebannerEdit,
  save: function save() {
    return null;
  }
});