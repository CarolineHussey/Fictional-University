wp.blocks.registerBlockType("ourblocktheme/singleprofessor", {
  title: "Theme Single Professor Page",
  edit: function () {
    return wp.element.createElement(
      "div",
      { className: "our-placeholder-block" },
      "Theme Single Professor Placeholder"
    );
  },
  save: function () {
    //return null to ensure 100% php processing
    return null;
  },
});
