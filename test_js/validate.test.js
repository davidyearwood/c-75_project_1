const Validate = require("../public/js/Validate");
var v = new Validate(); 


describe('The Validate isAlpha function', () => {
   describe("when an input value has any other character besides alpha characters", () => {
      it("should return a false boolean value", () => {
         expect(v.isAlpha("324")).toBeFalsy(); 
         expect(v.isAlpha(2345)).toBeFalsy(); 
         expect(v.isAlpha("3134csfs@")).toBeFalsy();
         expect(v.isAlpha("!#(&!(*")).toBeFalsy(); 
      });
   });
   
   describe("when an input value has only alpha characters", () => {
      it("should return a true boolean value", () => {
         expect(v.isAlpha("fsafhsdjfklma")).toBeTruthy();
      });
   });
});


describe('The Validate isPassword function', () => {
   
   describe("when a password has less than 6 characters", () => {
      it("should return a false boolean value", () => {
         expect(v.isPassword("as32d")).toBeFalsy(); 
      }); 
   });
   
   describe("when a password has more than 6 characters, but only alpha characteres", () => {
      it("should return a false boolean value", () => {
         expect(v.isPassword("aaaaaaa")).toBeFalsy();
      });
   });
   
   describe("when a password has 6 or more characters, but only numeric characters", () => {
      it("should return a false boolean value", () => {
         expect(v.isPassword("123456")).toBeFalsy();
      });
   });
   
   describe("when a password has 6 or more characters, and is a combination of alpha and numeric characters", () => {
      it("should return a true boolean value", () => {
         expect(v.isPassword("a21de1")).toBeTruthy();
      });
   });
});

describe("The Validate isEmail function", () => {
   describe("when a non-snytactically valid email address is entered", () => {
      it("should return a false boolean value", () => {
         expect(v.isEmail("1312.gmail.com")).toBeFalsy();
      });
   });
   
   describe("when a snytactically valid email address is entered", () => {
      it("should return a true boolean value", () => {
         expect(v.isEmail("dog@gmail.com")).toBeTruthy();
      });
   });
});

describe("The Validate isAlphaNum function", () => {
   
});