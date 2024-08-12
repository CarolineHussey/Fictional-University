wp.blocks.registerBlockType("ourblocktheme/header", {
  title: "Theme Header",
  edit: function () {
    return wp.element.createElement(
      "div",
      { className: "our-placeholder-block" },
      "Header Placeholder"
    );
  },
  save: function () {
    //return null to ensure 100% php processing
    return null;
  },
});
