import { Component, OnInit } from '@angular/core';

import { Observable } from 'rxjs/Observable';
import { Feedback } from 'models/feedback';
import { FeedbackService } from 'app/feedback/feedback.service';

@Component({
  selector: 'ctb-feedback',
  templateUrl: './feedback.component.html',
  styleUrls: ['./feedback.component.scss']
})
export class FeedbackComponent implements OnInit {
  feedback$: Observable<Array<Feedback>>;
  isLoading$: Observable<boolean>;

  constructor(
    private feedbackService: FeedbackService
  ) {
    this.isLoading$ = feedbackService.isLoading$;
  }

  ngOnInit() {
    this.feedback$ = this.feedbackService.get();
  }

}
