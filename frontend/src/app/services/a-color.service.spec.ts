import { TestBed } from '@angular/core/testing';

import { AColorService } from './a-color.service';

describe('AColorService', () => {
  let service: AColorService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(AColorService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
