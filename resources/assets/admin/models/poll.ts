import { Doc } from './doc';
import * as moment from 'moment';

export class PollAnswerOption extends Doc {
  text: string;
}

export class PollResponse extends Doc {
  poll_answer_option_id: number;
  user_id: number;
}

export class PollQuestion extends Doc {
  type: string;
  text: string;

  answer_options: Array<PollAnswerOption>;
  responses: Array<PollResponse>;
}

export class Poll extends Doc {
  title: string;
  response_count: number;
  starts_on: string;
  ends_on: string;

  questions: Array<PollQuestion>;

  get isCurrent() {
    return moment().isBetween(this.starts_on, this.ends_on);
  }

  constructor(body: any = {}) {
    super();
    Object.assign(this, body);
  }
}
