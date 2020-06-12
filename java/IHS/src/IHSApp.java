import java.util.Arrays;
import java.util.List;

import com.ibm.cloud.sdk.core.security.Authenticator;
import com.ibm.cloud.sdk.core.security.BasicAuthenticator;
import com.ibm.watson.health.acd.v1.AnnotatorForClinicalData;
import com.ibm.watson.health.acd.v1.model.Annotator.Name;
import com.ibm.watson.health.acd.v1.model.Concept;
import com.ibm.watson.health.acd.v1.model.ContainerGroup;
import com.ibm.watson.health.acd.v1.model.Flow;
import com.ibm.watson.health.acd.v1.model.MedicationAnnotation;
import com.ibm.watson.health.acd.v1.model.SymptomDisease;
import com.ibm.watson.health.acd.v1.util.CustomCollection;
import com.ibm.watson.health.acd.v1.util.FlowUtil;

public class IHSApp {

	public static void main(String[] args) {
		
		Authenticator authenticator = new BasicAuthenticator("apikey", "j41yqNg4YMXeot6QO00ldP8R1HWh1y2Usd9c5-l7Rbnb");
		AnnotatorForClinicalData acd = new AnnotatorForClinicalData(
		  "2020-03-31",
		  AnnotatorForClinicalData.DEFAULT_SERVICE_NAME,
		  authenticator);

		acd.setServiceUrl("https://us-south.wh-acd.cloud.ibm.com/wh-acd/api");
		
		if (args == null || args.length < 1 || args[0].isEmpty()) {
			System.out.println("Usage: java IHSApp <patient investigation/medication details>");
			System.exit(1);
		}
		/*
		 * Example: Simple /analyze request with a dynamic annotator flow
		 */
		//String text = "Patient has lung cancer, but did not smoke. She may consider chemotherapy as part of a treatment plan. mucinex, paracetamol";
		String text = args[0];

		/*
		 * List<String> annotators = Arrays.asList( Name.CONCEPT_DETECTION,
		 * Name.NEGATION);
		 */
		
		List<String> annotators = Arrays.asList(
				  Name.CONCEPT_DETECTION,
			      Name.MEDICATION,
			      Name.SYMPTOM_DISEASE);
			

		Flow flow = new FlowUtil.Builder().annotators(annotators).build();

		ContainerGroup resp = acd.analyze(text, flow);

		
	    List<Concept> concepts = resp.getConcepts();
		  
	    
	    StringBuffer sb = new StringBuffer();
	    if (concepts != null) {
			for (Concept c:concepts) {
				sb.append(c.getPreferredName()).append(",");
			}
			
			System.out.println("Concept:" + sb.toString());
	    }
	
		
		List<MedicationAnnotation> mediAnns = resp.getMedicationInd();

		if (mediAnns != null) {
			sb = new StringBuffer();
			for (MedicationAnnotation m:mediAnns) {
			     List<CustomCollection> drugs =  m.getDrug();
			     for (CustomCollection drug : drugs) {
			    	sb.append(drug.getValue("coveredText")).append(",");
				 }			     
			}
			System.out.println("Medication:" + sb.toString());
		} else {
			System.out.println("Medication:");
		}
		
		List<SymptomDisease> sypDisease = resp.getSymptomDisease();
		if (sypDisease != null) {
			sb = new StringBuffer();
			for (SymptomDisease symptomDisease : sypDisease) {
				sb.append(symptomDisease.getCoveredText()).append(",");
			}
			System.out.println("SymptomDisease:" + sb.toString());
		} else {
			System.out.println("SymptomDisease:");
		}

	}

}
