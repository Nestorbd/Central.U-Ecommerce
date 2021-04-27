import { TestBed } from '@angular/core/testing';

import { TTarifaService } from './t-tipo.service';

describe('TTarifaService', () => {
  let service: TTarifaService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(TTarifaService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
