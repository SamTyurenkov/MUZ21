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
  edit: function edit(props) {
    console.log(props);
    return /*#__PURE__*/React.createElement("div", null, "Text input:", /*#__PURE__*/React.createElement(TextControl, null), "Textarea:", /*#__PURE__*/React.createElement(TextareaControl, null), "Richtext:", /*#__PURE__*/React.createElement(RichText, null));
  },
  save: function save(props) {
    return /*#__PURE__*/React.createElement("div", null, ":)");
  }
});