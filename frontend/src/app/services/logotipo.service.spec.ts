import { TestBed } from '@angular/core/testing';

import { LogotipoService } from './logotipo.service';

describe('LogotipoService', () => {
  let service: LogotipoService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(LogotipoService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
