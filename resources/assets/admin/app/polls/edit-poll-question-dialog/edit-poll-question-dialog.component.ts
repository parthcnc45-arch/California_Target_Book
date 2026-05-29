import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { FormArray, FormBuilder, FormGroup, Validators as val } from '@angular/forms';
import { PollService } from '../poll.service';
import { Poll, PollQuestion } from '../../../models/poll';

@Component({
  selector: 'ctb-edit-poll-question-dialog',
  templateUrl: './edit-poll-question-dialog.component.html',
  styleUrls: ['./edit-poll-question-dialog.component.scss']
})
export class EditPollQuestionDialogComponent implements OnInit {

  pollForm: FormGroup;
  isLoading: boolean;

  get isNewQuestion() {
    return !this.data.question || !this.data.question.id;
  }

  constructor(
      private pollService: PollService,
      private dialogRef: MatDialogRef<EditPollQuestionDialogComponent>,
      private fb: FormBuilder,
      @Inject(MAT_DIALOG_DATA) private data: { pollId: number, question: PollQuestion },
  ) {
    const q = data.question || {
      text: '',
      type: 'multiple_choice',
      answer_options: [{ text: '' }],
    };

    this.pollForm = fb.group({
      text: [q.text, val.required],
      type: [q.type, val.required],
      responses: fb.array(q.answer_options.map(({ text }) => text))
    });
  }

  ngOnInit() {
  }

  addAnswerOption() {
    const fa = this.pollForm.get('responses') as FormArray;
    fa.push(this.fb.control(''));
  }

  removeAnswerOption(index: number) {
    const fa = this.pollForm.get('responses') as FormArray;
    fa.removeAt(index);
  }

  onSubmit(form: FormGroup) {
    if (form.invalid) return false;
    this.isLoading = true;

    const answers = form.value.responses
        .map(text => text.trim())
        .filter(text => !! text);

    const q = {
      text: form.value.text,
      type: form.value.type,
      answer_options: answers,
    };

    if (q.type === 'open') {
      q.answer_options = [];
    }

    let action;
    if (this.isNewQuestion) {
      action = this.pollService.createQuestion(this.data.pollId, q);
    } else {
      action = this.pollService.updateQuestion(this.data.pollId, this.data.question.id, q);
    }

    action
        .take(1)
        .do(() => this.isLoading = false)
        .subscribe(
            res => this.dialogRef.close(res),
            err => {
              console.error(err);
            }
        );

  }

}
