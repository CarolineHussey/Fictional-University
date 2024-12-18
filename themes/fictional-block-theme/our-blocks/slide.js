import apiFetch from "@wordpress/api-fetch";
import { Button, PanelBody, PanelRow } from "@wordpress/components";
import {
  InnerBlocks,
  InspectorControls,
  MediaUpload,
  MediaUploadCheck,
} from "@wordpress/block-editor";
import { registerBlockType } from "@wordpress/blocks";
import { useEffect } from "@wordpress/element";

registerBlockType("ourblocktheme/slide", {
  title: "Slide",
  supports: {
    align: ["full"],
  },
  attributes: {
    align: { type: "string", default: "full" },
    imgID: { type: "number" },
    imgURL: { type: "string", default: window.banner.fallbackimage },
    themeimage: { type: "string" },
  },
  edit: EditComponent,
  save: SaveComponent,
});

function EditComponent(props) {
  useEffect(
    function () {
      if (props.attributes.themeimage) {
        props.setAttributes({
          imgURL: `${slide.themeimagepath}${props.attributes.themeimage}`,
        });
      }
    },
    [] //runs on initial load
  );

  useEffect(
    function () {
      if (props.attributes.imgID) {
        async function go() {
          const response = await apiFetch({
            path: `/wp/v2/media/${props.attributes.imgID}`,
            method: "GET",
          });
          props.setAttributes({
            themeimage: "",
            imgURL: response.media_details.sizes.full.source_url,
          });
        }
        go();
      }
    },
    [props.attributes.imgID] //looks for a change to the imgID
  );

  function onFileSelect(x) {
    props.setAttributes({ imgID: x.id });
  }

  return (
    <>
      <InspectorControls>
        <PanelBody title="Background" initialOpen={true}>
          <PanelRow>
            <MediaUploadCheck>
              <MediaUpload
                onSelect={onFileSelect}
                value={props.attributes.imgID}
                render={({ open }) => {
                  return <Button onClick={open}>Choose Image</Button>;
                }}
              />
            </MediaUploadCheck>
          </PanelRow>
        </PanelBody>
      </InspectorControls>

      <div
        className="hero-slider__slide"
        style={{
          backgroundImage: `url('${props.attributes.imgURL}')`,
        }}
      >
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay t-center">
            <InnerBlocks
              allowedBlocks={[
                "ourblocktheme/genericheading",
                "ourblocktheme/genericbutton",
              ]}
            />
          </div>
        </div>
      </div>
    </>
  );
}

function SaveComponent() {
  return <InnerBlocks.Content />;
}
