wp.blocks.registerBlockType("ourblocktheme/notes", {
  title: "Theme Notes Page",
  edit: function () {
    return wp.element.createElement(
      "div",
      { className: "our-placeholder-block" },
      "Theme Notes Placeholder"
    );
  },
  save: function () {
    //return null to ensure 100% php processing
    return null;
  },
});
