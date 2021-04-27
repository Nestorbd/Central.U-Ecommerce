import { TestBed } from '@angular/core/testing';

import { ATallaService } from './a-talla.service';

describe('ATallaService', () => {
  let service: ATallaService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ATallaService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
