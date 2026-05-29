import * as moment from 'moment';

import { Doc } from './doc';
import { User } from './user';

export class Feedback extends Doc {
  user_id: number;
  tracker_session: number;
  feedback: string;
  user: User;
}
