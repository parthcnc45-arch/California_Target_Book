import { Pipe, PipeTransform } from '@angular/core';
import { PollQuestion } from 'models/poll';

@Pipe({
  name: 'questionData'
})
export class QuestionDataPipe implements PipeTransform {

  defaultColors = [{
    backgroundColor: [
      '#ffb74d',
      '#c14747',
      '#4788C1',
      '#F7D488',
      '#54AF77',
      '#3E51B5',
    ]
  }];

  transform(question: PollQuestion): any {
    const answerOptions = question.answer_options.reduce((map, o) => Object.assign(map, { [o.id]: o.text }), {});

    const emptyCounts = Object.keys(answerOptions).reduce((a, k) => Object.assign(a, { [answerOptions[k]]: 0 }), {});
    const counts = question.responses.reduce((data, r) => {
      const ao = answerOptions[r.poll_answer_option_id];
      data[ao]++;
      return data;
    }, emptyCounts);

    const labels = Object.keys(counts);

    return {
      labels,
      data: labels.map(k => counts[k]),
      colors: this.defaultColors,
    };
  }

}
