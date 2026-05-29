import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { Poll, PollQuestion } from 'models/poll';

@Injectable()
export class PollService {

  endpoint = '/api/polls';

  constructor(
      private http: HttpClient
  ) { }

  index() {
    return this.http.get<Array<Poll>>(this.endpoint)
        .map(polls => polls.map(p => new Poll(p)));
  }

  show(pollId) {
    return this.http.get<Poll>(`${this.endpoint}/${pollId}`);
  }

  getResponseData(pollId) {
    return this.http.get<any[]>(`${this.endpoint}/${pollId}/response-data`);
  }

  create(poll) {
    return this.http.post<Poll>(this.endpoint, poll);
  }

  update(pollId, body) {
    return this.http.put<Poll>(`${this.endpoint}/${pollId}`, body);
  }

  createQuestion(pollId: number, body) {
    return this.http.post<PollQuestion>(`${this.endpoint}/${pollId}/questions`, body);
  }

  updateQuestion(pollId: number, questionId: number, body) {
    return this.http.put<PollQuestion>(`${this.endpoint}/${pollId}/questions/${questionId}`, body);
  }

}
