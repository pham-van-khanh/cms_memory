// tailwind.config.js
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

export default {
  content: ['./resources/**/*.blade.php','./resources/**/*.js'],
  theme: {
    extend: {
      fontFamily: {
        display: ['"Cormorant Garamond"','serif'],
        script:  ['"Pinyon Script"','cursive'],
        hand:    ['"Caveat"','cursive'],
        sans:    ['"DM Sans"','sans-serif'],
      },
      keyframes: {
        fadeUp:   { from:{opacity:'0',transform:'translateY(24px)'}, to:{opacity:'1',transform:'translateY(0)'} },
        heroZoom: { from:{transform:'scale(1.06)'}, to:{transform:'scale(1.00)'} },
      },
      animation: {
        'fade-up':   'fadeUp .8s ease both',
        'hero-zoom': 'heroZoom 20s ease-in-out infinite alternate',
      },
    },
  },
  plugins: [typography, forms],
};
