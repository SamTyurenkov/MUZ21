const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { registerBlockType } = wp.blocks;
const { ServerSideRender } = wp.editor;
const { RichText, InspectorControls, BlockControls, AlignmentToolbar } =
  wp.blockEditor;
const {
  ToggleControl,
  PanelBody,
  PanelRow,
  CheckboxControl,
  SelectControl,
  ColorPicker,
  TextControl,
  TextareaControl,
  Toolbar,
  Button,
  Placeholder,
  Disabled,
} = wp.components;

class PostlistEdit extends Component {
  constructor(props) {
    super(props);

    this.state = {
      editMode: true,
    };
  }

  getInspectorControls = () => {
    const { attributes, setAttributes } = this.props;

    return (
      <InspectorControls>
        <PanelBody title="Настройки блока" initialOpen={true}>
          <PanelRow></PanelRow>
        </PanelBody>
      </InspectorControls>
    );
  };

  getBlockControls = () => {
    const { attributes, setAttributes } = this.props;

    return (
      <BlockControls>
        <Toolbar>
          <Button
            label={this.state.editMode ? "Preview" : "Edit"}
            icon={this.state.editMode ? "format-image" : "edit"}
            onClick={() => this.setState({ editMode: !this.state.editMode })}
          />
        </Toolbar>
      </BlockControls>
    );
  };

  render() {
    const { attributes, setAttributes } = this.props;
    return [
      this.getInspectorControls(),
      this.getBlockControls(),
      <div>
        {this.state.editMode && (
          <Fragment>
            <RichText
              value={attributes.title}
              tagName="h2"
              onChange={(newtext) => setAttributes({ title: newtext })}
            />
            <RichText
              value={attributes.subtitle}
              tagName="p"
              onChange={(newtext) => setAttributes({ subtitle: newtext })}
            />
          </Fragment>
        )}{" "}
        {!this.state.editMode && (
          <ServerSideRender
            block={this.props.name}
            attributes={{
              title: attributes.title,
              subtitle: attributes.subtitle,
              postlist: attributes.postlist,
            }}
          />
        )}
      </div>,
    ];
  }
}

registerBlockType("asp/postlist", {
  title: "Post List",
  category: "common",
  icon: "smiley",
  description: "Show custom post list",
  keywords: ["example", "test"],
  attributes: {
    title: {
      type: "string",
      default: "Заголовок",
    },
    subtitle: {
      type: "string",
      default: "Описание",
    },
    bannerside: {
      type: "string",
      default: "left",
    },
    postlist: {
      type: "array",
      default: [],
    },
  },
  edit: PostlistEdit,
  save: () => {
    return null;
  },
});
