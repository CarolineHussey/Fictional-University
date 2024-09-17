import { InnerBlocks } from "@wordpress/block-editor";
import metadata from "./block.json";
import Edit from "./edit";

wp.blocks.registerBlockType(metadata.name, {
  title: "Theme Banner",
  edit: Edit,
  save: function () {
    return <InnerBlocks.Content />;
  },
});
