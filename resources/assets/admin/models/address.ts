import { Doc } from './doc';

export class Address extends Doc {

    line1: String;
    line2: String;
    city: String;
    state: String;
    zip_code: String;
    special_instructions: String;

  constructor(body: any) {
    super();
    Object.assign(this, body);
  }
}
