"""
FaceNet Face Recognition Service
Handles face encoding, decoding, and matching operations
"""
import numpy as np
import cv2
import face_recognition
from pathlib import Path
import pickle
import hashlib
from datetime import datetime
import logging
from typing import Tuple, List, Optional, Dict
import os

logger = logging.getLogger(__name__)

class FaceNetService:
    """
    FaceNet service for face recognition operations
    Uses face_recognition library (dlib) for reliable face encoding
    """
    
    def __init__(self, tolerance=0.6, model='hog'):
        """
        Initialize FaceNet service
        
        Args:
            tolerance: Distance threshold for face matching (0-1)
            model: 'hog' for speed, 'cnn' for accuracy
        """
        self.tolerance = tolerance
        self.model = model
        self.encodings_cache = {}
        
        logger.info(f'FaceNetService initialized with tolerance={tolerance}, model={model}')
    
    def load_image(self, image_path: str) -> Optional[np.ndarray]:
        """
        Load image from file
        
        Args:
            image_path: Path to image file
            
        Returns:
            Image array or None if failed
        """
        try:
            image = face_recognition.load_image_file(image_path)
            logger.debug(f'Image loaded: {image_path}, shape={image.shape}')
            return image
        except Exception as e:
            logger.error(f'Failed to load image {image_path}: {str(e)}')
            return None
    
    def detect_faces(self, image: np.ndarray) -> List[Tuple]:
        """
        Detect faces in image using dlib
        
        Args:
            image: Image array (RGB format)
            
        Returns:
            List of face locations as (top, right, bottom, left) tuples
        """
        try:
            face_locations = face_recognition.face_locations(image, model=self.model)
            logger.debug(f'Detected {len(face_locations)} face(s)')
            return face_locations
        except Exception as e:
            logger.error(f'Face detection failed: {str(e)}')
            return []
    
    def get_face_encodings(self, image: np.ndarray, face_locations: List[Tuple] = None) -> List[np.ndarray]:
        """
        Generate 128-dimensional face encodings
        
        Args:
            image: Image array (RGB format)
            face_locations: Optional pre-detected face locations
            
        Returns:
            List of 128-dim encoding arrays
        """
        try:
            if face_locations is None:
                face_locations = self.detect_faces(image)
            
            if not face_locations:
                logger.warning('No faces found for encoding')
                return []
            
            encodings = face_recognition.face_encodings(image, face_locations)
            logger.debug(f'Generated {len(encodings)} encoding(s), each {len(encodings[0])} dimensions')
            return encodings
        except Exception as e:
            logger.error(f'Encoding generation failed: {str(e)}')
            return []
    
    def encode_face_from_image(self, image_path: str) -> Optional[np.ndarray]:
        """
        Complete pipeline: load image and generate encoding
        
        Args:
            image_path: Path to image file
            
        Returns:
            Face encoding array or None
        """
        image = self.load_image(image_path)
        if image is None:
            return None
        
        face_locations = self.detect_faces(image)
        if not face_locations:
            logger.warning(f'No faces detected in {image_path}')
            return None
        
        encodings = self.get_face_encodings(image, face_locations)
        if encodings:
            # Return the first (most prominent) face encoding
            return encodings[0]
        
        return None
    
    def compare_faces(self, encoding1: np.ndarray, encoding2: np.ndarray) -> Tuple[bool, float]:
        """
        Compare two face encodings
        
        Args:
            encoding1: First face encoding
            encoding2: Second face encoding
            
        Returns:
            (match: bool, distance: float) - Lower distance = better match
        """
        try:
            distance = face_recognition.face_distance([encoding1], encoding2)[0]
            match = distance <= self.tolerance
            return match, float(distance)
        except Exception as e:
            logger.error(f'Face comparison failed: {str(e)}')
            return False, 1.0
    
    def match_face_to_pool(self, test_encoding: np.ndarray, pool_encodings: List[np.ndarray]) -> Dict:
        """
        Match a face encoding against a pool of known encodings
        
        Args:
            test_encoding: Unknown face encoding
            pool_encodings: List of known face encodings
            
        Returns:
            Dict with best_match (bool), confidence (float), index (int)
        """
        if not pool_encodings:
            return {
                'best_match': False,
                'confidence': 0.0,
                'distance': 1.0,
                'index': -1
            }
        
        try:
            distances = face_recognition.face_distance(pool_encodings, test_encoding)
            best_idx = np.argmin(distances)
            best_distance = distances[best_idx]
            best_match = best_distance <= self.tolerance
            
            logger.debug(f'Pool matching: best_distance={best_distance:.4f}, match={best_match}')
            
            return {
                'best_match': bool(best_match),
                'confidence': float(1 - best_distance),  # Convert distance to confidence
                'distance': float(best_distance),
                'index': int(best_idx),
                'all_distances': distances.tolist()
            }
        except Exception as e:
            logger.error(f'Pool matching failed: {str(e)}')
            return {
                'best_match': False,
                'confidence': 0.0,
                'distance': 1.0,
                'index': -1
            }
    
    def save_encoding(self, encoding: np.ndarray, output_path: str) -> bool:
        """
        Save face encoding to file using pickle
        
        Args:
            encoding: Face encoding array
            output_path: Path to save file
            
        Returns:
            Success boolean
        """
        try:
            Path(output_path).parent.mkdir(parents=True, exist_ok=True)
            with open(output_path, 'wb') as f:
                pickle.dump(encoding, f)
            logger.info(f'Encoding saved to {output_path}')
            return True
        except Exception as e:
            logger.error(f'Failed to save encoding: {str(e)}')
            return False
    
    def load_encoding(self, encoding_path: str) -> Optional[np.ndarray]:
        """
        Load face encoding from file
        
        Args:
            encoding_path: Path to encoding file
            
        Returns:
            Face encoding array or None
        """
        try:
            with open(encoding_path, 'rb') as f:
                encoding = pickle.load(f)
            logger.debug(f'Encoding loaded from {encoding_path}')
            return encoding
        except Exception as e:
            logger.error(f'Failed to load encoding: {str(e)}')
            return None
    
    def get_image_hash(self, image_path: str) -> str:
        """
        Generate SHA256 hash of image for duplicate detection
        
        Args:
            image_path: Path to image file
            
        Returns:
            Hex hash string
        """
        try:
            sha256_hash = hashlib.sha256()
            with open(image_path, "rb") as f:
                for byte_block in iter(lambda: f.read(4096), b""):
                    sha256_hash.update(byte_block)
            return sha256_hash.hexdigest()
        except Exception as e:
            logger.error(f'Hash generation failed: {str(e)}')
            return ""
    
    def get_quality_metrics(self, image: np.ndarray, face_location: Tuple) -> Dict:
        """
        Calculate quality metrics for detected face
        
        Args:
            image: Image array
            face_location: Face location (top, right, bottom, left)
            
        Returns:
            Dict with quality metrics
        """
        try:
            top, right, bottom, left = face_location
            face_image = image[top:bottom, left:right]
            
            # Convert to grayscale for analysis
            if len(face_image.shape) == 3:
                gray = cv2.cvtColor(face_image, cv2.COLOR_RGB2GRAY)
            else:
                gray = face_image
            
            # Calculate metrics
            laplacian_var = cv2.Laplacian(gray, cv2.CV_64F).var()
            face_size = (right - left) * (bottom - top)
            
            # Normalized quality score (0-1)
            quality_score = min(1.0, laplacian_var / 100.0)
            
            return {
                'laplacian_variance': float(laplacian_var),
                'face_size': int(face_size),
                'quality_score': float(quality_score),
                'face_area': (right - left) * (bottom - top)
            }
        except Exception as e:
            logger.error(f'Quality metrics calculation failed: {str(e)}')
            return {'quality_score': 0.0}
