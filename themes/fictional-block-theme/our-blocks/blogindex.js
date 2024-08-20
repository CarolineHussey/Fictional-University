wp.blocks.registerBlockType("ourblocktheme/blogindex", {
  title: "Theme Blog Index Page",
  edit: function () {
    return wp.element.createElement(
      "div",
      { className: "our-placeholder-block" },
      "Theme Blog Index Page Placeholder"
    );
  },
  save: function () {
    //return null to ensure 100% php processing
    return null;
  },
});
