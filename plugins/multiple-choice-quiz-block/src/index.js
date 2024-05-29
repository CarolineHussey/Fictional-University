import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon, PanelBody, PanelRow, ColorPicker} from "@wordpress/components"
import "./index.scss"
import {InspectorControls, BlockControls, AlignmentToolbar} from "@wordpress/block-editor"
import {ChromePicker} from "react-color"

(function() {
    let locked = false;
    wp.data.subscribe(function() {
        const results = wp.data.select("core/block-editor").getBlocks().filter(function(block) {
            return block.name == "ourplugin/multiple-choice-quiz" && block.attributes.correctAnswer == undefined;
        })

        if (results.length && locked == false) {
            locked = true;
            wp.data.dispatch("core/editor").lockPostSaving("noanswer")
        }
    
        if (!results.length && locked == true) {
            locked = false;
            wp.data.dispatch("core/editor").unlockPostSaving("noanswer")
        }
    })
})()

wp.blocks.registerBlockType("ourplugin/multiple-choice-quiz", {
    title: "This is a test",
    icon: "smiley",
    category: "common",
    attributes: {
        question: {type: "string"},
        answers: {type: "array", default: [""] },
        correctAnswer: {type: "number", default: undefined},
        bgColor: {type: "string", default: "#EBEBEB"},
        theAlignment: {type: "string", defailt: "left"}
    },
    description: "Multi-purpose multiple choice quiz",
    example: {
        attributes: {
            question: "What's your favourite color?",
            answers: ["Yellow", "Blue"],
            correctAnswer: 1,
            bgColor: "#CFE8F1",
            theAlignment: "center"
    }
},

    edit: EditComponent,
    save: function (props) {
        return null
    },
})

function EditComponent(props) {
    function updateQuestion(value) {
        props.setAttributes({question: value});
    }

    function deleteAnswer(indexToDelete) {
        const newAnswers = props.attributes.answers.filter(function(x, index) {
            return index !=indexToDelete
        })
        props.setAttributes({answers: newAnswers})

        if (indexToDelete == props.attributes.correctAnswer) {
            props.setAttributes({correctAnswer: undefined});
        }
    }

    function markAsCorrect(index) {
        props.setAttributes({correctAnswer: index})
    }

    return (
    <div className="quiz-editor-block" style={{backgroundColor: props.attributes.bgColor}}>
        <BlockControls>
            <AlignmentToolbar value={props.attributes.theAlignment} onChange={x => props.setAttributes({theAlignment: x})} />
        </BlockControls>
        <InspectorControls>
            <PanelBody title="Background Color" initialOpen={true}></PanelBody>
            <PanelRow>
                <ChromePicker color={props.attributes.bgColor} onChangeComplete={x => props.setAttributes({bgColor: x.hex})} disableAlpha={true}/>
            </PanelRow>
        </InspectorControls>
        <TextControl label="Question:" value={props.attributes.question} onChange={updateQuestion} style={{fontSize: "20px"}}/>
        <p style={{fontSize: "11px", margin: "15px 0px 8px 0px" }}><strong>ANSWERS:</strong></p>
        {props.attributes.answers.map(function (answer, index) {
            return (
                <><Flex>
                    <FlexBlock>
                        <TextControl autoFocus={answer==undefined} value={answer} onChange={newValue => {
                            const newAnswers = props.attributes.answers.concat([])
                            newAnswers[index] = newValue
                            props.setAttributes({answers: newAnswers})
                        }}></TextControl>
                    </FlexBlock>
                    <FlexItem>
                        <Button onClick={() => markAsCorrect(index)}><Icon className="mark-as-correct" icon={props.attributes.correctAnswer == index ? "star-filled" : "star-empty"}></Icon></Button>
                    </FlexItem>
                    <FlexItem>
                        <Button isLink className="delete-button" onClick={() => deleteAnswer(index)}>Delete</Button>
                    </FlexItem>
                </Flex></>
            )
        }
        )}
        <Button isPrimary onClick={() => {
                    props.setAttributes({answers: props.attributes.answers.concat([undefined])});
                }}>Add another answer</Button>
    </div>
)
}