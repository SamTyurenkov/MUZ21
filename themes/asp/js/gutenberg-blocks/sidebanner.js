"use strict";

var __ = wp.i18n.__;
var registerBlockType = wp.blocks.registerBlockType;
var el = wp.element.createElement;
registerBlockType("asp/sidebanner", {
  title: "Side Banner",
  category: "common",
  icon: "smiley",
  description: "Show a banner and text",
  keywords: ["example", "test"],
  edit: function edit() {
    return /*#__PURE__*/React.createElement("div", null, ":)");
  },
  save: function save() {
    return /*#__PURE__*/React.createElement("div", null, ":)");
  }
});