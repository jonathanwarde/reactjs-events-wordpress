import { gsap } from 'gsap'
import { SplitText } from 'gsap/SplitText'

gsap.registerPlugin(SplitText)

const animHeroText = () => {
    const split1 = new SplitText("#anim-split-text-1", { type: "chars" });
    const split2 = new SplitText("#anim-split-text-2", { type: "chars" });
    const split2El = document.getElementById('anim-split-text-2')
    const split3 = document.getElementById('anim-split-text-3')

    const typing_text = gsap.timeline()
        // Animation for split1 (fade in from opacity 0)
        .from(split1.chars, {
            duration: 0.01,
            autoAlpha: 0, // Start with opacity 0
            stagger: {
                each: 0.08,
                onStart() {
                    let target = this.targets()[0];
                    let cursorPos = target.offsetLeft + target.offsetWidth;
                    gsap.set('.cursor', { x: cursorPos + 3 }); // Update cursor position
                }
            }
        })
        // Animation for split2 (fade in from opacity 0)
        .from(split2.chars, {
            duration: 0.01,
            autoAlpha: 0, // Start with opacity 0
            stagger: {
                each: 0.08,
                onStart() {
                    split2El.classList.add('custom-clip-path'); 
                    setTimeout(() => {
                        split2El.classList.add('added'); 
                      }, "10");
                    let target = this.targets()[0];
                    let cursorPos = target.offsetLeft + target.offsetWidth;
                    gsap.set('.cursor', { x: cursorPos + 3 }); // Update cursor position
                }
            }
        })
        .to(split1.chars, {
            duration: 0.2,
            autoAlpha: 1, // Fade in to opacity 1
            stagger: 0.08,
            onComplete() {
                split3.classList.remove('opacity-0')  
              }
        })
        .to(split2.chars, {
            duration: 0.2,
            autoAlpha: 1, // Fade in to opacity 1
            stagger: 0.08,
        })
       
}

export default animHeroText;
