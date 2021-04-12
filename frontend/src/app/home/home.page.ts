import { Component, OnInit, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { IonSlides, PopoverController } from '@ionic/angular';
import { Logotipo } from '../model/logotipo';
import { LogotipoService } from '../services/logotipo.service';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage implements OnInit {


  logotipo: Logotipo[];

  constructor(
    private logoService: LogotipoService,
    private router: Router,
    private popover: PopoverController
  ) {
    this.sliderOne =
    {
      isBeginningSlide: true,
      isEndSlide: false,
      slidesItems: [
        {
          id: 995
        },
        {
          id: 925
        },
        {
          id: 940
        },
        {
          id: 943
        },
        {
          id: 944
        }
      ]
    };
    //Item object for Food
    this.sliderTwo =
    {
      isBeginningSlide: true,
      isEndSlide: false,
      slidesItems: [
        {
          id: 324
        },
        {
          id: 321
        },
        {
          id: 435
        },
        {
          id: 524
        },
        {
          id: 235
        }
      ]
    };
    //Item object for Fashion
    this.sliderThree =
    {
      isBeginningSlide: true,
      isEndSlide: false,
      slidesItems: [
        {
          id: 643
        },
        {
          id: 532
        },
        {
          id: 232
        },
        {
          id: 874
        },
        {
          id: 193
        }
      ]
    };
  }

  ngOnInit(){
    this.getLogo()
  }



  @ViewChild('slideWithNav', { static: false }) slideWithNav: IonSlides;
  @ViewChild('slideWithNav2', { static: false }) slideWithNav2: IonSlides;
  @ViewChild('slideWithNav3', { static: false }) slideWithNav3: IonSlides;

  sliderOne: any;
  sliderTwo: any;
  sliderThree: any;


  //Configuration for each Slider
  slideOptsOne = {
    initialSlide: 0,
    slidesPerView: 1,
    autoplay: true
  };
  slideOptsTwo = {
    initialSlide: 1,
    slidesPerView: 2,
    loop: true,
    centeredSlides: true,
    spaceBetween: 20
  };
  slideOptsThree = {
    initialSlide: 0,
    slidesPerView: 3
  };


  //Move to Next slide
  slideNext(object, slideView) {
    slideView.slideNext(500).then(() => {
      this.checkIfNavDisabled(object, slideView);
    });
  }

  //Move to previous slide
  slidePrev(object, slideView) {
    slideView.slidePrev(500).then(() => {
      this.checkIfNavDisabled(object, slideView);
    });;
  }

  //Method called when slide is changed by drag or navigation
  SlideDidChange(object, slideView) {
    this.checkIfNavDisabled(object, slideView);
  }

  //Call methods to check if slide is first or last to enable disbale navigation  
  checkIfNavDisabled(object, slideView) {
    this.checkisBeginning(object, slideView);
    this.checkisEnd(object, slideView);
  }

  checkisBeginning(object, slideView) {
    slideView.isBeginning().then((istrue) => {
      object.isBeginningSlide = istrue;
    });
  }
  checkisEnd(object, slideView) {
    slideView.isEnd().then((istrue) => {
      object.isEndSlide = istrue;
    });
  }














  getLogo() {
    this.logoService.getLogos().subscribe((logotipo: any) => {
      this.logotipo = logotipo;
      console.log(this.logotipo)

    });
  }

  getLogoById(id: number){
    console.log(id+ " hola");
    this.logoService.getLogoById(id).subscribe(( logo : any) => {
    
    })
  }

  deleteLogo(id:number){
    console.log(id)
    this.logoService.deleteLogo(id)
  }

  addLogo(){
   this.router.navigateByUrl("add-logo");
  }

  updateLogo(id: number){
    this.logoService.setCurrentLogoId(id)

    this.router.navigateByUrl("update-logo")
  }
}
