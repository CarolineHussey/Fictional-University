wp.blocks.registerBlockType("ourblocktheme/footer", {
  title: "Theme Footer",
  edit: function () {
    return wp.element.createElement(
      "div",
      { className: "our-placeholder-block" },
      "Footer Placeholder"
    );
  },
  save: function () {
    //return null to ensure 100% php processing
    return null;
  },
});
