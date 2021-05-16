"use strict";

var __ = wp.i18n.__;
var registerBlockType = wp.blocks.registerBlockType;
var _wp$blockEditor = wp.blockEditor,
    RichText = _wp$blockEditor.RichText,
    InspectorControls = _wp$blockEditor.InspectorControls;
var _wp$components = wp.components,
    ToggleControl = _wp$components.ToggleControl,
    PanelBody = _wp$components.PanelBody,
    PanelRow = _wp$components.PanelRow,
    CheckboxControl = _wp$components.CheckboxControl,
    SelectControl = _wp$components.SelectControl,
    ColorPicker = _wp$components.ColorPicker,
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
    postIds: {
      type: "array",
      "default": []
    }
  },
  edit: function edit(props) {
    var attributes = props.attributes,
        setAttributes = props.setAttributes;
    console.log(props);
    return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(InspectorControls, null, /*#__PURE__*/React.createElement(PanelBody, {
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
    })))), /*#__PURE__*/React.createElement(RichText, {
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
    }));
  },
  save: function save(props) {
    var attributes = props.attributes;
    return /*#__PURE__*/React.createElement("div", {
      "class": "section"
    }, /*#__PURE__*/React.createElement("div", {
      "class": "banner {attributes.bannerside}"
    }), /*#__PURE__*/React.createElement("div", {
      "class": "content"
    }, /*#__PURE__*/React.createElement(RichText.Content, {
      tagName: "h2",
      value: attributes.title
    }), /*#__PURE__*/React.createElement(RichText.Content, {
      tagName: "p",
      value: attributes.subtitle
    })));
  }
});