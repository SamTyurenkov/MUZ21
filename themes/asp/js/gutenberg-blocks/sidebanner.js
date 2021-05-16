"use strict";

var __ = wp.i18n.__;
var registerBlockType = wp.blocks.registerBlockType;
var RichText = wp.blockEditor.RichText;
var _wp$components = wp.components,
    TextControl = _wp$components.TextControl,
    TextareaControl = _wp$components.TextareaControl;
registerBlockType("asp/sidebanner", {
  title: "Side Banner",
  category: "common",
  icon: "smiley",
  description: "Show a banner and text",
  keywords: ["example", "test"],
  attributes: {
    title: {
      type: 'string',
      "default": 'Заголовок'
    },
    subtitle: {
      type: 'string',
      "default": 'Описание'
    },
    postIds: {
      type: 'array',
      "default": []
    }
  },
  edit: function edit(props) {
    var attributes = props.attributes,
        setAttributes = props.setAttributes;
    console.log(props);
    return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(RichText, {
      value: attributes.title,
      onChange: function onChange(newtext) {
        return setAttributes({
          title: newtext
        });
      }
    }), /*#__PURE__*/React.createElement(RichText, {
      value: attributes.subtitle,
      onChange: function onChange(newtext) {
        return setAttributes({
          subtitle: newtext
        });
      }
    }));
  },
  save: function save(props) {
    return /*#__PURE__*/React.createElement("div", null, ":)");
  }
});