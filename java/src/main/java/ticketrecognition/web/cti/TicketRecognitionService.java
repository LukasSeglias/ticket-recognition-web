package ticketrecognition.web.cti;

import javax.ejb.Singleton;
import javax.inject.Inject;
import java.util.logging.Level;
import java.util.logging.Logger;

@Singleton
public class TicketRecognitionService {

    private static final Logger LOG = Logger.getLogger(MatcherService.class.getName());
    private static final String LIBRARY_NAME = "ticket_recognition_jcpp";

    static {
        LOG.log(Level.INFO, "Load library {}", LIBRARY_NAME);
        try {
            System.loadLibrary(LIBRARY_NAME);
        } catch (UnsatisfiedLinkError exc) {
            LOG.log(Level.SEVERE, "Failed loading library", exc);
        }
    }

    private MatcherService matcherService;
    private ReaderService readerService;

    public MatcherService matcher() {
        return matcherService;
    }

    public ReaderService reader() {
        return readerService;
    }

    @Inject
    void setMatcherService(MatcherService matcherService) {
        this.matcherService = matcherService;
    }

    @Inject
    void setReaderService(ReaderService readerService) {
        this.readerService = readerService;
    }
}
