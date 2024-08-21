import metadata from "./block.json";
import Edit from "./edit";

wp.blocks.registerBlockType(metadata.name, {
  title: "Theme Footer",
  edit: Edit,
  /*save: function () {
    //return null to ensure 100% php processing
    return null;
  },*/
});
