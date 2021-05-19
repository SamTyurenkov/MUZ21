"use strict";

var registerBlockType = wp.blocks.registerBlockType;
var _wp = wp,
    ServerSideRender = _wp.serverSideRender;
var _wp$blockEditor = wp.blockEditor,
    InspectorControls = _wp$blockEditor.InspectorControls,
    MediaUpload = _wp$blockEditor.MediaUpload,
    MediaUploadCheck = _wp$blockEditor.MediaUploadCheck;
var _wp$components = wp.components,
    PanelBody = _wp$components.PanelBody,
    Button = _wp$components.Button,
    ResponsiveWrapper = _wp$components.ResponsiveWrapper;
var Fragment = wp.element.Fragment;
var withSelect = wp.data.withSelect;
var __ = wp.i18n.__;

var BlockEdit = function BlockEdit(props) {
  var attributes = props.attributes,
      setAttributes = props.setAttributes;

  var removeMedia = function removeMedia() {
    props.setAttributes({
      mediaId: 0,
      mediaUrl: ""
    });
  };

  var onSelectMedia = function onSelectMedia(media) {
    props.setAttributes({
      mediaId: media.id,
      mediaUrl: media.url
    });
  };

  return /*#__PURE__*/React.createElement(Fragment, null, /*#__PURE__*/React.createElement(InspectorControls, null, /*#__PURE__*/React.createElement(PanelBody, {
    title: __("Select block background image", "awp"),
    initialOpen: true
  }, /*#__PURE__*/React.createElement("div", {
    className: "editor-post-featured-image"
  }, /*#__PURE__*/React.createElement(MediaUploadCheck, null, /*#__PURE__*/React.createElement(MediaUpload, {
    onSelect: onSelectMedia,
    value: attributes.mediaId,
    allowedTypes: ["image"],
    render: function render(_ref) {
      var open = _ref.open;
      return /*#__PURE__*/React.createElement(Button, {
        className: attributes.mediaId == 0 ? "editor-post-featured-image__toggle" : "editor-post-featured-image__preview",
        onClick: open
      }, attributes.mediaId == 0 && __("Choose an image", "awp"), props.media != undefined && /*#__PURE__*/React.createElement(ResponsiveWrapper, {
        naturalWidth: props.media.media_details.width,
        naturalHeight: props.media.media_details.height
      }, /*#__PURE__*/React.createElement("img", {
        src: props.media.source_url
      })));
    }
  })), attributes.mediaId != 0 && /*#__PURE__*/React.createElement(MediaUploadCheck, null, /*#__PURE__*/React.createElement(MediaUpload, {
    title: __("Replace image", "awp"),
    value: attributes.mediaId,
    onSelect: onSelectMedia,
    allowedTypes: ["image"],
    render: function render(_ref2) {
      var open = _ref2.open;
      return /*#__PURE__*/React.createElement(Button, {
        onClick: open,
        isDefault: true,
        isLarge: true
      }, __("Replace image", "awp"));
    }
  })), attributes.mediaId != 0 && /*#__PURE__*/React.createElement(MediaUploadCheck, null, /*#__PURE__*/React.createElement(Button, {
    onClick: removeMedia,
    isLink: true,
    isDestructive: true
  }, __("Remove image", "awp")))))), /*#__PURE__*/React.createElement(ServerSideRender, {
    block: attributes.name,
    attributes: {
      blockname: "justbanner",
      mediaUrl: attributes.mediaUrl
    }
  }));
};

registerBlockType("asp/justbanner", {
  title: "Just Banner",
  icon: "smiley",
  category: "layout",
  supports: {
    align: true
  },
  attributes: {
    mediaId: {
      type: "number",
      "default": 0
    },
    mediaUrl: {
      type: "string",
      "default": ""
    }
  },
  edit: withSelect(function (select, props) {
    return {
      media: props.attributes.mediaId ? select("core").getMedia(props.attributes.mediaId) : undefined
    };
  })(BlockEdit),
  save: function save() {
    return null;
  }
});