wp.blocks.registerBlockType("ourblocktheme/archivecampus", {
  title: "Events Campus Page",
  edit: function () {
    return wp.element.createElement(
      "div",
      { className: "our-placeholder-block" },
      "Theme Campus Placeholder"
    );
  },
  save: function () {
    //return null to ensure 100% php processing
    return null;
  },
});
