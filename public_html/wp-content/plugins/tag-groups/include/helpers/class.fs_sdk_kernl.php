<?php

/**
* Tag Groups Premium
*
* @package    Tag Groups Premium
* @author     Christoph Amthor
* @copyright  2019 Christoph Amthor (@ Chatty Mango, chattymango.com)
* @license    see official vendor website
* @since      1.19.0
*
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*
*/
if ( !class_exists( 'FS_SDK_Kernl' ) ) {
    /**
     * Dummy replacement for Freemius SDK - for use when plugin is distributed through legacy channels
     *
     */
    class FS_SDK_Kernl
    {
        /**
         *
         */
        public function can_use_premium_code()
        {
            return true;
        }
        
        /**
         * Return true so that we don't run accidentally PluginUpdateChecker when not on Kernl
         */
        public function is_free_plan()
        {
            return false;
        }
        
        /**
         * Activate all plans
         */
        public function is_plan( $plan = '', $exact = false )
        {
            return true;
        }
        
        /**
         *
         */
        public function is_paying()
        {
            return true;
        }
        
        /**
         * Activate all plans
         */
        public function is_plan_or_trial( $plan = '', $exact = false )
        {
            return true;
        }
        
        /**
         *
         */
        public function is_premium()
        {
            return true;
        }
        
        /**
         *
         */
        public function add_filter( $filter_id, $function )
        {
        }
    
    }
}