#import "misc.h"
@implementation misc
- (id)stripDoubleSpaceFrom:(NSString*)str {
NSString *strz = [str retain];
/*    while ([strz rangeOfString:@"  "].location != NSNotFound) {
        strz = [strz stringByReplacingOccurrencesOfString:@"  " withString:@" "];
    }*/
    return strz;
}
@end
