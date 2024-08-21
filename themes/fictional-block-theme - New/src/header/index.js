import metadata from "./block.json";
import Edit from "./edit";

wp.blocks.registerBlockType(metadata.name, {
  title: "Theme Header",
  edit: Edit,
});
