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
  attributes: {
    title: {
      type: "string",
      selector: "h2"
    },
    subtitle: {
      type: "array",
      source: "children",
      selector: "p"
    },
    image: {
      type: "image",
      selector: "img"
    }
  },
  edit: function edit(props) {
    function onChangeSubtitle(content) {
      props.attributes({
        subtitle: content
      });
    }

    function onChangeTitle(content) {
      props.attributes({
        title: content
      });
    }

    function onChangeImage(content) {
      props.attributes({
        image: content
      });
    }

    return /*#__PURE__*/React.createElement("div", {
      className: props.className
    }, /*#__PURE__*/React.createElement("div", {
      "class": "gray-bg"
    }, /*#__PURE__*/React.createElement(RichText, {
      tagName: "h2",
      role: "textbox",
      "aria-multiline": "true",
      value: props.attributes.title,
      onChange: onChangeTitle
    }), /*#__PURE__*/React.createElement(RichText, {
      tagName: "p",
      role: "textbox",
      "aria-multiline": "true",
      value: props.attributes.subtitle,
      onChange: onChangeSubtitle
    }))); //return null;
  },
  save: function save() {
    return null;
  }
});