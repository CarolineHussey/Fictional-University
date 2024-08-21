import metadata from "./block.json";
import Edit from "./edit";

wp.blocks.registerBlockType(metadata.name, {
  title: "Page Placeholder",
  edit: Edit,
});
