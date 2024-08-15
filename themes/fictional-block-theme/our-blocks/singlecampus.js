wp.blocks.registerBlockType("ourblocktheme/singlecampus", {
  title: "Single Campus",
  edit: function () {
    return wp.element.createElement(
      "div",
      { className: "our-placeholder-block" },
      "Single Campus Placeholder"
    );
  },
  save: function () {
    //return null to ensure 100% php processing
    return null;
  },
});
