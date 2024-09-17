export default Edit;
import { useBlockProps } from "@wordpress/block-editor";

function Edit() {
  const blockProps = useBlockProps();
  return (
    <div {...blockProps}>
      <div className="our-placeholder-block">Header Placeholder</div>
    </div>
  );
}
