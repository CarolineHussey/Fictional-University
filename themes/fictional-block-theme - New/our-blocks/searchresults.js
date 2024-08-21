wp.blocks.registerBlockType("ourblocktheme/searchresults", {
  title: "Theme Search Results Page",
  edit: function () {
    return wp.element.createElement(
      "div",
      { className: "our-placeholder-block" },
      "Theme Search Results Placeholder"
    );
  },
  save: function () {
    //return null to ensure 100% php processing
    return null;
  },
});
