/**
 * CKEditor 5 abbreviation plugin for TYPO3 13 / CKEditor 47.
 *
 * Icons must not be imported from @ckeditor/ckeditor5-core (removed in CKEditor 47).
 * Keep this as a single file so sibling ./imports cannot hit year-long _assets cache.
 */

import { Plugin } from '@ckeditor/ckeditor5-core';
import {
    ButtonView,
    ContextualBalloon,
    clickOutsideHandler,
    View,
    LabeledFieldView,
    createLabeledInputText,
    submitHandler
} from '@ckeditor/ckeditor5-ui';

class AbbreviationEditing extends Plugin {
    static get pluginName() {
        return 'AbbreviationEditing';
    }

    init() {
        this.editor.model.schema.extend('$text', {
            allowAttributes: ['abbreviation']
        });

        const conversion = this.editor.conversion;

        conversion.for('downcast').attributeToElement({
            model: 'abbreviation',
            view: (modelAttributeValue, { writer }) => writer.createAttributeElement('abbr', {
                title: modelAttributeValue
            })
        });

        conversion.for('upcast').elementToAttribute({
            view: {
                name: 'abbr',
                attributes: ['title']
            },
            model: {
                key: 'abbreviation',
                value: (viewElement) => viewElement.getAttribute('title')
            }
        });
    }
}

class FormView extends View {
    constructor(locale) {
        super(locale);

        this.abbrInputView = this._createInput('Add abbreviation');
        this.titleInputView = this._createInput('Add title');
        this.saveButtonView = this._createButton('Save', 'ck-button-save');
        this.saveButtonView.type = 'submit';
        this.cancelButtonView = this._createButton('Cancel', 'ck-button-cancel');
        this.cancelButtonView.delegate('execute').to(this, 'cancel');

        this.childViews = this.createCollection([
            this.abbrInputView,
            this.titleInputView,
            this.saveButtonView,
            this.cancelButtonView
        ]);

        this.setTemplate({
            tag: 'form',
            attributes: {
                class: ['ck', 'ck-abbr-form'],
                tabindex: '-1'
            },
            children: this.childViews
        });
    }

    render() {
        super.render();
        submitHandler({ view: this });
    }

    focus() {
        this.childViews.first.focus();
    }

    _createInput(label) {
        const labeledInput = new LabeledFieldView(this.locale, createLabeledInputText);
        labeledInput.label = label;
        return labeledInput;
    }

    _createButton(label, className) {
        const button = new ButtonView();
        button.set({
            label,
            tooltip: true,
            withText: true,
            class: className
        });
        return button;
    }
}

class AbbreviationUI extends Plugin {
    static get pluginName() {
        return 'AbbreviationUI';
    }

    static get requires() {
        return [ContextualBalloon];
    }

    init() {
        const editor = this.editor;
        this._balloon = editor.plugins.get(ContextualBalloon);
        this.formView = this._createFormView();

        editor.ui.componentFactory.add('abbreviation', () => {
            const button = new ButtonView();
            button.set({
                label: 'Abbreviation',
                tooltip: true,
                withText: true
            });
            this.listenTo(button, 'execute', () => this._showUI());
            return button;
        });
    }

    _createFormView() {
        const editor = this.editor;
        const formView = new FormView(editor.locale);

        this.listenTo(formView, 'submit', () => {
            const title = formView.titleInputView.fieldView.element.value;
            const abbr = formView.abbrInputView.fieldView.element.value;
            editor.model.change((writer) => {
                editor.model.insertContent(writer.createText(abbr, { abbreviation: title }));
            });
            this._hideUI();
        });

        this.listenTo(formView, 'cancel', () => this._hideUI());

        clickOutsideHandler({
            emitter: formView,
            activator: () => this._balloon.visibleView === formView,
            contextElements: () => [this._balloon.view.element],
            callback: () => this._hideUI()
        });

        return formView;
    }

    _showUI() {
        this._balloon.add({
            view: this.formView,
            position: this._getBalloonPositionData()
        });
        this.formView.focus();
    }

    _hideUI() {
        this._clearInput(this.formView.abbrInputView);
        this._clearInput(this.formView.titleInputView);
        if (this.formView.element) {
            this.formView.element.reset();
        }
        this._balloon.remove(this.formView);
        this.editor.editing.view.focus();
    }

    _clearInput(labeledInput) {
        const fieldView = labeledInput && labeledInput.fieldView;
        if (!fieldView) {
            return;
        }
        fieldView.value = '';
        if (fieldView.element) {
            fieldView.element.value = '';
        }
    }

    _getBalloonPositionData() {
        const view = this.editor.editing.view;
        const viewDocument = view.document;
        return {
            target: () => {
                const range = viewDocument.selection.getFirstRange();
                if (range) {
                    return view.domConverter.viewRangeToDom(range);
                }
                return this.editor.ui.getEditableElement();
            }
        };
    }
}

export default class Abbreviation extends Plugin {
    static get pluginName() {
        return 'Abbreviation';
    }

    static get requires() {
        return [AbbreviationEditing, AbbreviationUI];
    }
}
