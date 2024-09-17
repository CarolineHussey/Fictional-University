import metadata from "./block.json";
import Edit from "./edit";

wp.blocks.registerBlockType(metadata.name, {
  title: "Single Post",
  edit: Edit,
});
