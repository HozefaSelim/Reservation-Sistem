declare module "lottie-web" {
  export interface AnimationItem {
    destroy: () => void;
    // Add other properties and methods as needed.
  }

  export function loadAnimation(params: {
    container: HTMLElement;
    animationData: object;
    loop?: boolean;
    autoplay?: boolean;
  }): AnimationItem;
}
