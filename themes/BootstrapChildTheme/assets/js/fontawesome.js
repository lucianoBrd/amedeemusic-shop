// FontAwesome Icons
// Import icons one by one to reduce size of the output
import { library, dom } from '@fortawesome/fontawesome-svg-core';

import { faAngleRight } from '@fortawesome/free-solid-svg-icons/faAngleRight';
import { faTiktok } from '@fortawesome/free-brands-svg-icons/faTiktok';

library.add(faTiktok, faAngleRight);
dom.watch();
