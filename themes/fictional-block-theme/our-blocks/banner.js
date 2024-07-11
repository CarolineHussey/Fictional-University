import { InnerBlocks } from "@wordpress/block-editor";
import { registerBlockType } from "@wordpress/blocks";

//the first arguement is namespace/blockname which is instantiated within registerBlockType (namespace is the namespace that all blocks will use; banner is the name of this particular block)
registerBlockType("ourblocktheme/banner", {
  title: "Banner",
  supports: {
    align: ["full"],
  },
  attributes: {
    align: { type: "string", default: "full" },
  },
  edit: EditComponent,
  save: SaveComponent,
});

function EditComponent() {
  const forLater = (
    <>
      <h1 className="headline headline--large">Welcome!</h1>
      <h2 className="headline headline--medium">
        We think you&rsquo;ll like it here.
      </h2>
      <h3 className="headline headline--small">
        Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re
        interested in?
      </h3>
      <a href="#" className="btn btn--large btn--blue">
        Find Your Major
      </a>
    </>
  );
  return (
    <div className="page-banner">
      <div
        className="page-banner__bg-image"
        style={{
          backgroundImage:
            "url('/wp-content/themes/fictional-block-theme/images/library-hero.jpg')",
        }}
      ></div>
      <div className="page-banner__content container t-center c-white">
        <InnerBlocks allowedBlocks={["ourblocktheme/genericheading"]} />
      </div>
    </div>
  );
}

function SaveComponent() {
  return (
    <div className="page-banner">
      <div
        className="page-banner__bg-image"
        style={{
          backgroundImage:
            "url('/wp-content/themes/fictional-block-theme/images/library-hero.jpg')",
        }}
      ></div>
      <div className="page-banner__content container t-center c-white">
        <InnerBlocks.Content />
      </div>
    </div>
  );
}
