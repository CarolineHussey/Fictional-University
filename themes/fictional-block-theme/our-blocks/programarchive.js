wp.blocks.registerBlockType("ourblocktheme/programarchive", {
  title: "Theme Program Archive Page",
  edit: function () {
    return wp.element.createElement(
      "div",
      { className: "our-placeholder-block" },
      "Theme Program Archive Placeholder"
    );
  },
  save: function () {
    //return null to ensure 100% php processing
    return null;
  },
});
