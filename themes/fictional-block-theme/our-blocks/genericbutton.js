import ourColors from "../inc/constants";
import { link } from "@wordpress/icons";
import { registerBlockType } from "@wordpress/blocks";
import {
  RichText,
  InspectorControls,
  BlockControls,
  __experimentalLinkControl as LinkControl,
  getColorObjectByColorValue,
} from "@wordpress/block-editor";
import {
  ToolbarGroup,
  withFocusOutside,
  ToolbarButton,
  Popover,
  Button,
  PanelBody,
  PanelRow,
  ColorPalette,
} from "@wordpress/components";
import { useState } from "@wordpress/element";

registerBlockType("ourblocktheme/genericbutton", {
  title: "Generic Button",
  attributes: {
    text: { type: "string" },
    size: { type: "string", default: "large" },
    linkObject: { type: "object", default: { url: "" } },
    colorName: { type: "string", default: "blue" },
  },
  edit: EditComponent,
  save: SaveComponent,
});

function EditComponent(props) {
  const [LinkPickerState, setLinkPickerState] = useState(false);
  function handleTextChange(x) {
    props.setAttributes({ text: x });
  }

  function buttonHandler() {
    setLinkPickerState((prev) => !prev);
  }

  function handleLinkChange(newLink) {
    props.setAttributes({ linkObject: newLink });
  }

  const currentColorValue = ourColors.filter((colorObject) => {
    return colorObject.name == props.attributes.colorName;
  })[0].color;

  function handleColorChange(colorCode) {
    // find color name from the hex code provided by the color palette
    const { name } = getColorObjectByColorValue(ourColors, colorCode);
    props.setAttributes({ colorName: name });
  }

  return (
    <>
      <BlockControls>
        <ToolbarGroup>
          <ToolbarButton onClick={buttonHandler} icon={link}></ToolbarButton>
        </ToolbarGroup>
        <ToolbarGroup>
          <ToolbarButton
            isPressed={props.attributes.size === "large"}
            onClick={() => props.setAttributes({ size: "large" })}
          >
            Large
          </ToolbarButton>
          <ToolbarButton
            isPressed={props.attributes.size === "medium"}
            onClick={() => props.setAttributes({ size: "medium" })}
          >
            Medium
          </ToolbarButton>
          <ToolbarButton
            isPressed={props.attributes.size === "small"}
            onClick={() => props.setAttributes({ size: "small" })}
          >
            Small
          </ToolbarButton>
        </ToolbarGroup>
      </BlockControls>
      <InspectorControls>
        <PanelBody title="Color" initialOpen={true}>
          <PanelRow>
            <ColorPalette
              disableCustomColors={true}
              clearable={false}
              colors={ourColors}
              value={currentColorValue}
              onChange={handleColorChange}
            />
          </PanelRow>
        </PanelBody>
      </InspectorControls>
      <RichText
        allowedFormats={[]}
        tagName="a"
        className={`btn btn--${props.attributes.size} btn--${props.attributes.colorName}`}
        value={props.attributes.text}
        onChange={handleTextChange}
      />
      {LinkPickerState && (
        <Popover
          position="middle center"
          onFocusOutside={() => setIsLinkPickerVisible(false)}
        >
          <LinkControl
            settings={[]}
            value={props.attributes.linkObject}
            onChange={handleLinkChange}
          />
          <Button
            variant="primary"
            onClick={() => setLinkPickerState(false)}
            style={{ display: "block", width: "100%" }}
          ></Button>
        </Popover>
      )}
    </>
  );
}

function SaveComponent(props) {
  return (
    <a
      href={props.attributes.linkObject.url}
      className={`btn btn--${props.attributes.size} btn--${props.attributes.colorName}`}
    >
      {props.attributes.text}
    </a>
  );
}
