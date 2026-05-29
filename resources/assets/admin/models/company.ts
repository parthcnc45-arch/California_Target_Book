import { Doc } from './doc';
import { Address } from './address';

export class Company extends Doc {
  name: String;
  address: Address;
}
