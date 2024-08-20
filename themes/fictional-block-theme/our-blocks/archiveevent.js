wp.blocks.registerBlockType("ourblocktheme/archiveevent", {
  title: "Events Archive Page",
  edit: function () {
    return wp.element.createElement(
      "div",
      { className: "our-placeholder-block" },
      "Theme Events Placeholder"
    );
  },
  save: function () {
    //return null to ensure 100% php processing
    return null;
  },
});
